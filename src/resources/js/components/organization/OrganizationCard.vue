<template>
  <div>
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <img
          :src="getCardImage(organization)"
          class="rounded mx-auto d-block img-fluid"
          :alt="organization.name"
          @click="goToOrg(organization)">
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-lg-3 offset-lg-3">
        <p>
          <strong>{{ $t('organization.attr.name') }}:</strong>
          <router-link :to="{name: 'organization.details', params: {uid: organization.uid}}">
            {{ organization.name }}
          </router-link>
        </p>
      </div>
      <div class="col-lg-3">
        <p>
          <strong> {{ $t('organization.attr.homepage_url') }}</strong>: <a
            :href="organizationModel.getHomepageUrl()"
            target="_blank">{{ organizationModel.getHomepageUrl(true) }}</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { Organization } from '../../models/organization';
export default {
    props: {
        organization: {
            type: Object,
            default: function () {
                return {};
            }
        }
    },
    data() {
        return {
            organizationModel: null
        };
    },
    mounted() {
        this.organizationModel = new Organization(this.organization);
    },
    methods: {

        getCardImage(organization) {
            if (organization.images && organization.images.header && organization.images.header.urls) {
                return organization.images.header.urls.original;
            }
            return '/img/production/default-header.jpg';
        },
        goToOrg(organization) {
            this.$router.push({name: 'organization.details', params: {uid: organization.uid}});
        }
    }
};
</script>

<style scoped>
  img {
    max-height: 15em;
    width: 100%;
    cursor: pointer;
    margin-bottom: .5em;
  }


</style>