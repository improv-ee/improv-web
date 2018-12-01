<template>
    <div v-if="organization.slug">

        <crud-toolbar resource-name="organizations"
                      :resource-id="$route.params.slug"></crud-toolbar>


        <h1>{{organization.name}}</h1>


        <h2>{{ $t('organization.members') }}</h2>

        <b-table striped hover :items="members"></b-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                organization: {},
                members: []
            }
        },
        methods: {


        },
        mounted() {
            axios.get('/api/organizations/' + this.$route.params.slug)
                .then(response => {
                    this.organization = response.data.data;
                });
        }
    }
</script>
