<template>
    <div>
        <p><span v-html="$t('production.list_intro')"></span></p>
        <p class="text-right">
            <b-button :to="{name: 'production.create'}" variant="primary"
                   class="btn btn-sm mb-3">{{ $t("production.create_new") }}
            </b-button>
        </p>

        <div class="table-responsive">
            <table class="table table-hover table-clickable">
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
        <pagination :data="productions.meta" @pagination-change-page="getResults"
                    class="justify-content-center"></pagination>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                productions: {},
                newProductionTitle: ' '
            }
        },
        methods: {
            createProduction(e) {
                e.preventDefault();
                if (!this.newProductionTitle) {
                    return
                }
                let self = this;
                axios.post(config.apiUrl + '/productions', {"title": this.newProductionTitle})
                    .then(function (response) {
                        self.$router.push({
                            name: 'production.edit',
                            params: {slug: response.data.data.slug}
                        })
                    });
            },

            getResults(page = 1) {
                axios.get(config.apiUrl + '/productions?onlyMine=true', {params: {page: page}})
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
