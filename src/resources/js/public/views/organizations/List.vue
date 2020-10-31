<template>
  <div>
    <div
      v-if="organizations.length"
      class="row">
      <div class="col-12">
        <organization-card
          v-for="organization in organizations"
          :key="organization.uid"
          :organization="organizationFactory(organization)" />
      </div>
    </div>
    <loading-spinner v-else />
  </div>
</template>

<script>
import OrganizationCard from '../../../components/organization/OrganizationCard';
import { Organization } from '../../../models/organization';
export default {
    components: {
        OrganizationCard,
    },
    data() {
        return {
            organizations: []
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {
        organizationFactory(organizationData){
            return new Organization(organizationData);
        },
        getResults(page = 1) {
            axios.get(config.apiUrl + '/organizations', {params: {page: page, 'filter[is_public]': 1}})
                .then(response => {
                    this.organizations = response.data.data;
                });
        }
    },
    metaInfo () {
        return {
            title: this.$t('nav.organizations')
        };
    }
};
</script>
