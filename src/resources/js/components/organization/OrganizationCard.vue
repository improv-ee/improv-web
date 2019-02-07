<template>
    <b-card text-variant="white"
            overlay
            @click="goToOrg(organization)"
            :img-src="getCardImage(organization)"
            :img-alt="organization.slug">
    </b-card>
</template>

<script>
    export default {
        props: ['organization'],
        methods: {

            getCardImage(organization) {
                if (organization.images && organization.images.header && organization.images.header.urls) {
                    return organization.images.header.urls.original;
                }
                return '/img/production/default-header.jpg';
            },
            goToOrg(organization){
                this.$router.push({name: 'organization.details', params: {slug: organization.slug}});
            }
        }
    }
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