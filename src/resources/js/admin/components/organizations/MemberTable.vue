<template>
    <b-table id="org-members-table" v-if="members" striped outlined responsive hover :items="items" :fields="fields"></b-table>
</template>

<script>

    export default {
        props: ['members'],
        data: function () {
            return {
                items: [],
                fields: {
                    username: {
                        label: 'test',
                        sortable: true
                    },
                    role: {
                        label: 'test',
                        sortable: true
                    }
                }
            }
        },
        watch: {
            members: function(){
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
