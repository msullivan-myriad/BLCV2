<template>
        <div class="stats-goal" v-on:click="open4">
            <h3>{{this.goal.name}}</h3>
            <h4>Cost: {{this.goal.cost}}</h4>
            <h4>Days: {{this.goal.days}}</h4>
            <h4>Hours: {{this.goal.hours}}</h4>
        </div>
</template>


<script>

    export default {

        props: ['goal'],

        methods: {
            onClick: function () {
                console.log('Test for now');
            },

            open4: function() {
                const h = this.$createElement;
                this.$msgbox({
                        title: 'Message',
                        message: h('p', null, [
                            h('span', null, 'Message can be '),
                            h('i', {style: 'color: teal'}, 'VNode')
                        ]),
                        showCancelButton: true,
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel',
                        beforeClose: (action, instance, done) => {
                        if (action === 'confirm')
                {
                    instance.confirmButtonLoading = true;
                    instance.confirmButtonText = 'Loading...';
                    setTimeout(() => {
                        done();
                    setTimeout(() => {
                        instance.confirmButtonLoading = false;
                },
                    300
                )
                    ;
                },
                    3000
                )
                    ;
                }
            else
                {
                    done();
                }
            }
            }).
                then(action => {
                    this.$message({
                    type: 'info',
                    message: 'action: ' + action
                });
            })
                ;
            },

        }
    }

</script>


