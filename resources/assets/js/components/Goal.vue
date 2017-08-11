<template>
        <div class="panel">
            <h4>{{this.goal.name}}</h4>
            <button v-on:click="onSubmit"><i class="fa fa-plus" aria-hidden="true"></i></button>
            <br>

            <el-tooltip content="Goal Cost" placement="bottom" effect="dark">
                <div class="el-tooltip-content-wrapper">
                    <i class="fa fa-usd" aria-hidden="true"></i>
                    <span>{{this.goal.cost}}</span>
                </div>
            </el-tooltip>

            <el-tooltip content="Goal Hours" placement="bottom" effect="dark">
                <div class="el-tooltip-content-wrapper">

                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <span>{{this.goal.hours}}</span>
                </div>
            </el-tooltip>

            <el-tooltip content="Goal Days" placement="bottom" effect="dark">
                <div class="el-tooltip-content-wrapper">

                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span>{{this.goal.days}}</span>
                </div>
            </el-tooltip>

            <el-tooltip content="User with this goal" placement="bottom" effect="dark">
                <div class="el-tooltip-content-wrapper">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span>{{this.goal.subgoals_count}}</span>
                </div>
            </el-tooltip>


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

<style scoped>

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

</style>

