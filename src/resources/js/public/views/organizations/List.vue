<template>
    <div>

        <div class="row" v-if="organizations.length">
            <div class="col-10 offset-1">
                <b-card v-for="organization in organizations"
                        :key="organization.slug"
                        img-top class="mb-2">
                    <p class="card-text">
                        {{ organization.name }}
                    </p>

                    <b-button :to="{name: 'organization.details', params: {slug: organization.slug}}"
                              variant="info"   class="btn">{{ $t('ui.view_details') }}</b-button>

                </b-card>
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

            getResults(page = 1) {
                axios.get('/api/organizations', {params: {page: page}})
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
