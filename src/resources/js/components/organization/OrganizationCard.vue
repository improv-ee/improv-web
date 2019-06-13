<template>
  <b-card
    text-variant="white"
    overlay
    :img-src="getCardImage(organization)"
    :img-alt="organization.name"
    @click="goToOrg(organization)" />
</template>

<script>
export default {
    props: {
        organization: {
            type: Object,
            default: function () {
                return {};
            }
        }
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
  .card-img {
    max-height: 20rem;
  }

  .card {
    margin-bottom: 2rem;
    margin-top: 2rem;
    cursor: pointer;
  }
</style>