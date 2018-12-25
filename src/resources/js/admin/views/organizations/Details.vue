<template>
    <div v-if="organization.slug">

        <crud-toolbar resource-name="organizations" :showEdit="isAdmin" :showDelete="isAdmin"
                      :resource-id="$route.params.slug"></crud-toolbar>


        <h1>{{ organization.name }}</h1>

        <vue-markdown :source="organization.description"></vue-markdown>

        <h2>{{ $t('organization.members') }}</h2>

        <member-table :members="organization.members"></member-table>
    </div>
</template>

<script>

    import MemberTable from '../../components/organizations/MemberTable';
    import VueMarkdown from 'vue-markdown'

    export default {
        components: {
            MemberTable,
            VueMarkdown
        },
        data() {
            return {
                organization: {},
            }
        },

        computed: {
            isAdmin: function () {
                for (let i in this.organization.members) {
                    let member = this.organization.members[i];
                    if (member.username === window.config.username && member.role === window.config.organization.ROLE_ADMIN) {
                        return true;
                    }
                }
                return false;
            }
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
