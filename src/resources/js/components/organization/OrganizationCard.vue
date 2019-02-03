<template>
    <b-card text-variant="white"
            overlay
            @click="goToOrg(organization)"
            :title="organization.name"
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

    h4.card-title {
        text-align: center;
        background-color: rgba(0, 0, 0, 0.34);
        text-transform: uppercase;
        padding: 1rem;
    }
    .card-img-overlay {
        padding: 0;
    }

    .card {
        margin-bottom: 2rem;
        margin-top: 2rem;
        cursor: pointer;
    }
</style>