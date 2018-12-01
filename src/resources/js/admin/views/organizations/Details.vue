<template>
    <div v-if="organization.slug">

        <crud-toolbar resource-name="organizations"
                      :resource-id="$route.params.slug"></crud-toolbar>


        <h1>{{organization.name}}</h1>


        <h2>{{ $t('organization.members') }}</h2>

        <member-table :members="organization.members"></member-table>
    </div>
</template>

<script>

    import MemberTable from '../../components/organizations/MemberTable';
    export default {
        components: {
            MemberTable
        },
        data() {
            return {
                organization: {},
            }
        },
        methods: {


        },
        mounted() {
            let self = this;
            axios.get('/api/organizations/' + this.$route.params.slug)
                .then(response => {
                    self.organization = response.data.data;
                });
        }
    }
</script>
