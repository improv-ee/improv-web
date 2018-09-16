<template>
    <div>
        <p><span v-html="$t('production.list_intro')"></span></p>
        <p class="text-right">
            <b-btn v-b-modal.modal-new-production
                         class="btn btn-sm btn-outline-secondary mb-3">{{ $t("production.create_new") }}</b-btn></p>
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
        :modal-ok="$t('ui.create')" :modal-cancel="$t('ui.cancel')" @ok="createProduction">
            <b-form @submit.prevent="createProduction">

                <b-form-group
                        :label="$t('production.attr.title')"
                        label-for="title"
                        :description="$t('production.attr.title_description')">
                    <b-form-input id="title"
                                  type="text"
                                  v-model="newProductionTitle"
                                  :state="newProductionTitle.length"
                                  required
                                  :placeholder="$t('production.attr.title_placeholder')">
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
                newProductionTitle: ''
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
