<template>
  <b-table
    v-if="members"
    id="org-members-table"
    striped
    outlined
    responsive
    hover
    :items="items"
    :fields="fields">
    <template
      v-slot:cell(avatar)="data">
      <router-link
        :to="{ name: 'organizations.people.details', params: { uid: organizationUid, username: data.item.username }}">
        <img
          class="img-thumbnail"
          :src="data.value"
          alt="Avatar"
          width="100">
      </router-link>
    </template>
    <template
      slot="username"
      slot-scope="data">
      <router-link
        :to="{ name: 'organizations.people.details', params: { uid: organizationUid, username: data.value }}">
        {{ data.value }}
      </router-link>
    </template>
  </b-table>
</template>

<script>

export default {
    props: {
        members: {
            type: Array,
            default: function () {
                return [];
            }
        },
        organizationUid: {
            type: String,
            default: ''
        }
    },
    data: function () {
        return {
            items: [],
            fields: [
                {
                    key: 'avatar',
                    sortable: false,
                    formatter: 'avatar'
                },
                {
                    key: 'username',
                    label: 'username',
                    sortable: true
                },
                {
                    key: 'role',
                    label: 'role',
                    sortable: true
                }
            ]
        };
    },
    watch: {
        members: function () {
            this.refresh();
        }
    },
    mounted() {
        this.fields[1].label = this.$i18n.t('user.username');
        this.fields[2].label = this.$i18n.t('organization.user.role.role');
        this.refresh();
    },
    methods: {
        refresh() {
            this.items = [];
            for (let i = 0; i < this.members.length; i++) {
                let self = this;

                axios.get(config.apiUrl + '/users/' + this.members[i].username)
                    .then(response => {

                        let roleLabel = self.members[i].role === 0 ? self.$i18n.t('organization.user.role.admin') : self.$i18n.t('organization.user.role.member');
                        self.items.push({
                            'avatar': response.data.data.avatar,
                            'username': self.members[i].username,
                            role: roleLabel
                        });
                    });

            }
        }
    }
};
</script>
