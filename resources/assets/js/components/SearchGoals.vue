<template>

    <div class="panel panel-default">
        <div class="panel-heading">Search All Goals</div>

        <div class="panel-body">
            <input v-on:keyup="sendSearch(searchTerm)" type="text" name="search" placeholder="Search" v-model="searchTerm">
            <hr>
            <goal v-for="result in searchResults" :goal="result" :key="result.id"></goal>
        </div>

    </div>

</template>

<script>

    import _ from 'lodash';

    export default {

        data: () => ({
            searchTerm: '',
            searchResults: [],
            goals: [],
            errors: [],
        }),

        // Fetches posts when the component is created.
        created() {
            axios.get(`/api/goals`)
                .then(response => {
                // JSON responses are automatically parsed.
                this.goals = response.data.data.all_goals;
                })
                .catch(errors => {
                    this.errors.push(errors)
               })

        },

        methods: {

            sendSearch: _.debounce(function(searchTerm) {

                axios.get('/api/search', {
                    params: {
                        search: searchTerm
                    }
                })
                .then(response => {
                    this.searchResults = response.data;
                })
                .catch(errors => {
                    this.errors.push(errors);
                })

            }, 10),

        },


    }

</script>


