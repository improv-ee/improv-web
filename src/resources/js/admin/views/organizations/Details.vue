<template>
    <div v-if="organization.slug">

        <crud-toolbar resource-name="organizations"
                      :resource-id="$route.params.slug"></crud-toolbar>


        <h1>{{organization.name}}</h1>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                organization: {},
            }
        },
        methods: {


        },
        mounted() {
            axios.get('/api/organization/' + this.$route.params.slug)
                .then(response => {
                    this.organization = response.data.data;
                });
        }
    }
</script>
