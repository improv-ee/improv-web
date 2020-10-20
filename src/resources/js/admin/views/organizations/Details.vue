<template>
  <div v-if="organization.uid">
    <crud-toolbar
      resource-name="organizations"
      :show-edit="isAdmin"
      :show-delete="isAdmin"
      :resource-id="$route.params.uid" />


    <h1>{{ organization.name }}</h1>

    <img
      v-if="organization.images.header"
      :src="organization.images.header.urls.original"
      :alt="organization.image"
      class="img-responsive header-img">


    <vue-markdown :source="organization.description" />

    <h2>{{ $t('organization.members') }}</h2>

    <member-table
      :members="organization.members"
      :organization-uid="this.$route.params.uid" />


    <h2>{{ $t('organization.add_member') }}</h2>
    <p>{{ $t('organization.add_member_help') }}</p>
    <b-form
      v-if="isAdmin"
      @submit.prevent="addMember">
      <b-form-group
        id="newMember"
        class="col-x2-5"
        label-for="newMemberUsername">
        <user-select
          v-model="newMember" />
      </b-form-group>


      <b-button
        type="submit"
        :disabled="!newMember.username"
        variant="primary">
        {{ $t('organization.add_member') }}
      </b-button>
    </b-form>

    <h2>{{ $t('nav.gigs') }}</h2>
    <p>{{ $t('gigs.intro_help') }}</p>

    <gig-table />
  </div>
</template>

<script>

import MemberTable from '../../components/organizations/MemberTable';
import VueMarkdown from 'vue-markdown';
import UserSelect from '../../components/UserSelect';
import GigTable from './gigs/GigTable';

export default {
    components: {
        MemberTable,
        VueMarkdown,
        UserSelect,
        GigTable
    },
    data() {
        return {
            organization: {},
            newMember: {}
        };
    },
    computed: {
        isAdmin: function () {
            for (let i in this.organization.members) {
                let member = this.organization.members[i];
                if (member.username === window.config.username && member.role === 0) {
                    return true;
                }
            }
            return false;
        }
    },
    mounted() {
        this.loadOrganization();
    },
    methods: {
        addMember() {
            let self = this;
            axios.post(`${config.apiUrl}/organizations/${this.$route.params.uid}/membership`, {username: this.newMember.username})
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
            axios.get(config.apiUrl + '/organizations/' + this.$route.params.uid)
                .then(response => {
                    self.organization = response.data.data;
                });
        }

    }
};
</script>
