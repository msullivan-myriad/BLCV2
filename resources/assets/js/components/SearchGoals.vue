<template>

    <div class="panel panel-default">
        <div class="panel-heading">Add Goals</div>

        <div class="panel-body">
            <input v-on:keyup="sendSearch(searchTerm)" type="text" class="main-search" name="search" placeholder="Search" v-model="searchTerm">
            <hr>
            <goal v-for="result in searchResults" :goal="result" :key="result.id"></goal>

            <div class="panel new-goal-form" v-if="displayNewGoalForm">
                <input class="search-term" name="search-term" v-model="searchTerm"/>
                <button v-on:click="onSubmit"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <br>
                <el-tooltip content="Goal Cost" placement="bottom" effect="dark">
                    <div class="el-tooltip-content-wrapper">
                        <i class="fa fa-usd" aria-hidden="true"></i>
                        <input class="number-input" placeholder="Cost" name="cost" v-model="newGoalCost"/>
                    </div>
                </el-tooltip>

                <el-tooltip content="Goal Hours" placement="bottom" effect="dark">
                    <div class="el-tooltip-content-wrapper">

                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <input class="number-input" placeholder="Hours" name="hours" v-model="newGoalHours"/>
                    </div>
                </el-tooltip>

                <el-tooltip content="Goal Days" placement="bottom" effect="dark">
                    <div class="el-tooltip-content-wrapper">

                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <input class="number-input" placeholder="Days" name="days" v-model="newGoalDays"/>
                    </div>
                </el-tooltip>

            </div>

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
            newGoalCost: '',
            newGoalHours: '',
            newGoalDays: ''
        }),

        computed: {
            displayNewGoalForm: function() {
                var display = false;

                console.log(this.searchResults);

                if (this.searchTerm.length) {
                    display = true;
                }

                return display;

            }
        },


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

            onSubmit: function() {
                alert('Do something');
            },

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


<style scoped>

   input.main-search {
       width: 100%;
       border: 1px solid #b9b9b9;
       padding: 4px 10px;
       border-radius: 2px;
   }


   h4 {
       color: #217d84;
       display: inline-block;
       max-width: 80%;
   }

   button {
       display: inline-block;
       float: right;
       border: none;
       background: none;
       box-shadow: none;
   }

   button i.fa {
       font-size: 20px;
       margin: 14px 14px 0 0;

   }

   .el-tooltip-content-wrapper {
       display: inline-block;
       font-size: 16px;
       margin: 0 4px;
       padding: 0 12px;
   }


   .el-tooltip-content-wrapper i.fa {
       font-size: 14px;
   }

   .new-goal-form input.search-term {
       width: 100%;
   }

    .new-goal-form input.number-input {
        display: inline-block;
        width: 80px;
        border: none;
    }

</style>

