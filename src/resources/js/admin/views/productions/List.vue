<template>
    <div>
    <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>{{ $t("production.name") }}</th>
                    <th>{{ $t("production.num_of_events") }}</th>
                </tr>
                </thead>
                <tbody>
                <production-table-row :production="production"
                                      v-for="production in productions.data"
                :key="production.slug"></production-table-row>
                </tbody>
            </table>
</div>
        <pagination :data="productions.meta" @pagination-change-page="getResults" class="justify-content-center"></pagination>
</div>
</template>

<script>
    export default {
        data() {
            return {
                productions:  {},
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/productions',{params:{page:page}})
                    .then(response => {
                        this.productions = response.data;
                    });
            }
        },
        mounted() {
            this.getResults()
        }
    }
</script>
