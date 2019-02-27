<template>
  <div>
    <b-card
      :title="membership.user.name"
      :img-src="membership.user.avatar"
      img-alt="Avatar"
      img-top
      tag="article"
      style="max-width: 20rem;">
      <b-input-group :prepend="$t('organization.user.role.role')">
        <b-form-select
          v-model="userRole"
          :options="roleOptions" />
        <b-input-group-append>
          <b-button @click="changeMembership">
            {{ $t('ui.edit') }}
          </b-button>
        </b-input-group-append>
      </b-input-group>


      <hr>

      <b-button
        variant="danger"
        @click="removeMember">
        {{ $t('organization.remove_member') }}
      </b-button>
    </b-card>
  </div>
</template>

<script>


export default {
    data() {
        return {
            membership: {},
            userRole: null,
            roleOptions: [
                {value: 0, text: this.$i18n.t('organization.user.role.admin')},
                {value: 1, text: this.$i18n.t('organization.user.role.member')}
            ]
        };
    },

    mounted() {
        this.loadMember();
    },
    methods: {
        removeMember() {
            let self = this;
            axios.delete(`${config.apiUrl}/organizations/${this.$route.params.slug}/membership/${this.$route.params.username}`)
                .then(function () {
                    self.$router.push({
                        name: 'organization.details',
                        params: {slug: self.$route.params.slug}
                    });
                });

        },
        loadMember() {
            let self = this;
            axios.get(`${config.apiUrl}/organizations/${this.$route.params.slug}/membership/${this.$route.params.username}`)
                .then(response => {
                    self.membership = response.data.data;
                    self.userRole = self.getCurrentRole(response.data.data.organization, self.$route.params.username);
                });
        },
        changeMembership() {
            let self = this;
            axios.put(`${config.apiUrl}/organizations/${this.$route.params.slug}/membership/${this.$route.params.username}`, {
                role: this.userRole
            }).then(
                self.$router.push({
                    name: 'organization.details',
                    params: {slug: self.$route.params.slug}
                })
            );
        },
        getCurrentRole(organization, username) {
            for (let i in organization.members) {
                if (organization.members[i].username === username) {
                    return organization.members[i].role;
                }
            }
            return null;
        }
    }
};
</script>

