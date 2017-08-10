<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Most Popular Goals</div>

                    <div class="panel-body">
                        <goal v-for="goal in goals" :goal="goal" :key="goal.id"></goal>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {

        data: () => ({
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

        }

    }

</script>


