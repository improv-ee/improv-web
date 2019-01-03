<template>
    <div v-if="organization.slug">

        <crud-toolbar resource-name="organizations" :showEdit="isAdmin" :showDelete="isAdmin"
                      :resource-id="$route.params.slug"></crud-toolbar>


        <h1>{{ organization.name }}</h1>

        <vue-markdown :source="organization.description"></vue-markdown>

        <h2>{{ $t('organization.members') }}</h2>

        <member-table :members="organization.members" :organization-slug="this.$route.params.slug"></member-table>


        <b-form @submit.prevent="addMember" v-if="isAdmin" inline>

            <b-form-group id="newMember"
                          label-for="newMemberUsername">
                <b-form-input id="newMemberUsername"
                              type="text"
                              v-model="newMemberUsername"
                              required
                              :placeholder="$t('user.username')">
                </b-form-input>
            </b-form-group>


            <b-button type="submit" variant="primary">{{ $t('organization.add_member') }}</b-button>
        </b-form>


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
                newMemberUsername: null
            }
        },
        methods: {
            addMember() {
                let self = this;
                axios.post(`${config.apiUrl}/organizations/${ this.$route.params.slug }/membership`, {username: this.newMemberUsername})
                    .then(function () {
                        self.loadOrganization();
                    }).catch(function (error) {
                    if (error.response.status === 422) {
                        Vue.notify({
                            group: 'app',
                            type: 'error',
                            title: self.$t('ui.validation_error'),
                            text: self.$t('user.not_found')
                        });
                    }
                });

            },
            loadOrganization() {
                let self = this;
                axios.get(config.apiUrl + '/organizations/' + this.$route.params.slug)
                    .then(response => {
                        self.organization = response.data.data;
                    });
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
            this.loadOrganization();
        }
    }
</script>
