<template>
    <b-table id="org-members-table" v-if="members" striped outlined responsive hover :items="items" :fields="fields">
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
                    let roleLabel = this.members[i].role === 0 ? this.$i18n.t('organization.user.role.admin') : this.$i18n.t('organization.user.role.member');
                    this.items.push({"username": this.members[i].username, role: roleLabel});
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
