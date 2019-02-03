<template>
    <div>
        <p><span v-html="$t('organization.list_intro')"></span></p>
        <p class="text-right">
            <b-btn v-b-modal.modal-new-organization
                   class="btn btn-sm btn-primary mb-3">{{ $t("organization.create_new") }}
            </b-btn>
        </p>


        <div class="row" v-if="organizations.length">
            <div class="col-10 offset-1">
                <organization-card v-for="organization in organizations"
                                   :key="organization.slug"
                                   :organization="organization"></organization-card>

            </div>
        </div>

        <div class="row" v-else>
            <div class="col-10 offset-1">
                <b-alert show>{{ $t('organization.you_dont_have_any') }}</b-alert>

            </div>
        </div>


        <b-modal id="modal-new-organization" :title="$t('organization.create_new')"
                 :ok-title="$t('ui.create')" :cancel-title="$t('ui.cancel')" @ok="createOrganization">
            <b-form @submit.prevent="createOrganization">

                <b-form-group
                        :label="$t('organization.attr.name')"
                        label-for="title">
                    <b-form-input id="title"
                                  type="text"
                                  v-model="newOrganizationName"
                                  required>
                    </b-form-input>
                </b-form-group>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
    import OrganizationCard from '../../../components/organization/OrganizationCard';
    export default {
        components: {
            OrganizationCard,
        },
        data() {
            return {
                organizations: [],
                newOrganizationName: '',
            }
        },
        methods: {
            createOrganization(e) {

                if (!this.newOrganizationName.length) {
                    e.preventDefault();
                    return
                }

                let self = this;
                axios.post(config.apiUrl + '/organizations', {"name": this.newOrganizationName})
                    .then(function (response) {
                        self.$router.push({
                            name: 'organization.edit',
                            params: {slug: response.data.data.slug}
                        })
                    })
                    .catch(function (error) {
                        Vue.notify({
                            group: 'app',
                            type: 'error',
                            title: self.$t('ui.validation_error'),
                            text: self.$t('organization.name_taken')
                        });
                    });
            },

            getResults(page = 1) {
                axios.get(config.apiUrl + '/organizations', {params: {page: page, onlyMine: 1}})
                    .then(response => {
                        this.organizations = response.data.data;
                    });
            }
        },
        mounted() {
            this.getResults()
        }
    }
</script>
