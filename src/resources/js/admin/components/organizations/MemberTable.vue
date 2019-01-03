<template>
    <b-table id="org-members-table" v-if="members" striped outlined responsive hover :items="items" :fields="fields">
        <template slot="avatar" slot-scope="data">
            <router-link
                    :to="{ name: 'organizations.people.details', params: { slug: organizationSlug, username: data.item.username }}">
                <img class="img-thumbnail" :src="data.value" alt="Avatar" width="100"/>
            </router-link>
        </template>
        <template slot="username" slot-scope="data">
           <router-link
                    :to="{ name: 'organizations.people.details', params: { slug: organizationSlug, username: data.value }}">
                {{ data.value }}
            </router-link>
        </template>
    </b-table>
</template>

<script>

    export default {
        props: ['members', 'organizationSlug'],
        data: function () {
            return {
                items: [],
                fields: {
                    avatar: {
                        sortable: false
                    },
                    username: {
                        label: 'username',
                        sortable: true
                    },
                    role: {
                        label: 'role',
                        sortable: true
                    }
                }
            }
        },
        watch: {
            members: function () {
                this.refresh()
            }
        },
        methods: {
            refresh() {
                this.items = [];
                for (let i = 0; i < this.members.length; i++) {
                    let self = this;

                    axios.get(config.apiUrl + '/users/' + this.members[i].username)
                        .then(response => {

                            let roleLabel = self.members[i].role === 0 ? self.$i18n.t('organization.user.role.admin') : self.$i18n.t('organization.user.role.member');
                            self.items.push({"avatar": response.data.data.avatar,"username": self.members[i].username, role: roleLabel});
                        });

                }
            }
        },
        mounted() {
            this.fields.username.label = this.$i18n.t('user.username');
            this.fields.role.label = this.$i18n.t('organization.user.role.role');
            this.refresh();
        }
    }
</script>
