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
                <b-card v-for="organization in organizations"
                        :key="organization.slug"
                        img-top>
                    <p class="card-text">
                        {{ organization.name }}
                    </p>

                    <b-button :to="{name: 'organization.details', params: {slug: organization.slug}}"
                           variant="info"   class="btn">{{ $t('ui.view_details') }}</b-button>

                </b-card>
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
    export default {
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
                axios.post('/api/organizations', {"name": this.newOrganizationName})
                    .then(function (response) {
                        self.$router.push({
                            name: 'organization.edit',
                            params: {slug: response.data.data.slug}
                        })
                    });
            },

            getResults(page = 1) {
                axios.get('/api/organizations', {params: {page: page, onlyMine: 1}})
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
