<template>
    <div>
        <p><span v-html="$t('production.list_intro')"></span></p>
        <p class="text-right">
            <router-link :to="{ name: 'production.new'}"
                         class="btn btn-sm btn-outline-secondary mb-3">{{ $t("production.create_new") }}</router-link></p>
    <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>{{ $t("production.attr.title") }}</th>
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
