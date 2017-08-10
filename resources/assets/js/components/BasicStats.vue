<template>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Basic Stats</div>

                <div class="panel-body">
                    {{ stats }}
                </div>

            </div>
        </div>
    </div>

</template>

<script>


    export default {

        data: () => ({
            stats: [],
            errors: [],
        }),

        // Fetches posts when the component is created.
        created() {
            axios.get(`/api/stats/base`)
                .then(response => {
                // JSON responses are automatically parsed.
                this.stats = response.data.data;
                })
                .catch(errors => {
                    this.errors.push(errors)
               })
        }

    }

</script>


