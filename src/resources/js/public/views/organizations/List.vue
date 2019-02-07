<template>
    <div>

        <div class="row" v-if="organizations.length">
            <div class="col-12">
                <organization-card v-for="organization in organizations"
                                   :key="organization.slug"
                                   :organization="organization"></organization-card>
            </div>
        </div>
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

            getResults(page = 1) {
                axios.get(config.apiUrl + '/organizations', {params: {page: page, 'filter[is_public]': 1}})
                    .then(response => {
                        this.organizations = response.data.data;
                    });
            }
        },
        mounted() {
            this.getResults()
        },
        metaInfo () {
            return {
                title: this.$t('nav.organizations')
            }
        }
    }
</script>
