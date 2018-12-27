<template>
    <div>
        <p><span v-html="$t('production.list_intro')"></span></p>
        <p class="text-right">
            <b-btn v-b-modal.modal-new-production variant="primary"
                         class="btn btn-sm mb-3">{{ $t("production.create_new") }}</b-btn></p>
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
        <pagination :data="productions.meta" @pagination-change-page="getResults" class="justify-content-center"></pagination>


        <b-modal id="modal-new-production" :title="$t('production.create_new')"
        :ok-title="$t('ui.create')" :cancel-title="$t('ui.cancel')" @ok="createProduction">
            <b-form @submit.prevent="createProduction">

                <b-form-group
                        :label="$t('production.attr.title')"
                        label-for="title"
                        :description="$t('production.attr.title_description')">
                    <b-form-input id="title"
                                  type="text"
                                  v-model.trim="newProductionTitle"
                                  :state="newProductionTitle.length > 0"
                                  required>
                    </b-form-input>
                </b-form-group>
            </b-form>
        </b-modal>
</div>
</template>

<script>
    export default {
        data() {
            return {
                productions:  {},
                newProductionTitle: ' '
            }
        },
        methods: {
            createProduction(e){
                e.preventDefault();
                if (!this.newProductionTitle){
                    return
                }
                let self = this;
                axios.post('/api/productions', {"title":this.newProductionTitle})
                    .then(function (response) {
                        self.$router.push({
                            name: 'production.edit',
                            params: { slug: response.data.data.slug }
                        })
                    });
            },

            getResults(page = 1) {
                axios.get('/api/productions?onlyMine=true',{params:{page:page}})
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
