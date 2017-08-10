<template>
        <div class="panel">
            <h2><a href="#">{{this.goal.name}}</a></h2>
            <h4>Cost: {{this.goal.cost}}</h4>
            <h4>Days: {{this.goal.days}}</h4>
            <h4>Hours: {{this.goal.hours}}</h4>
            <h4>Subgoal Count: {{this.goal.subgoals_count}}</h4>
            <button v-on:click="onSubmit">+</button>
        </div>
</template>


<script>

    export default {

        props: ['goal'],

        methods: {

            onSubmit: function() {

                axios.post('/api/goals/' + this.goal.id, {
                    goal_id: this.goal.id,
                    cost: this.goal.cost,
                    days: this.goal.days,
                    hours: this.goal.hours,
                })
                .then(response => {

                    this.$notify({
                        title: 'Success',
                        message: this.goal.name + ' was successfully added to your list',
                        type: 'success'
                    });


                })
                .catch(errors => {
                    console.log('Errors');
                    console.log(errors.response.data);


                    this.$notify({
                        title: 'Error',
                        message: errors.response.data,
                        type: 'error'
                    });

                });

            }
        }

    }

</script>


