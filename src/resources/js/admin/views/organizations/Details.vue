<template>
  <div v-if="organization.slug">
    <crud-toolbar
      resource-name="organizations"
      :show-edit="isAdmin"
      :show-delete="isAdmin"
      :resource-id="$route.params.slug" />


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
      :organization-slug="this.$route.params.slug" />


    <b-form
      v-if="isAdmin"
      inline
      @submit.prevent="addMember">
      <b-form-group
        id="newMember"
        label-for="newMemberUsername">
        <b-form-input
          id="newMemberUsername"
          v-model="newMemberUsername"
          type="text"
          required
          :placeholder="$t('user.username')" />
      </b-form-group>


      <b-button
        type="submit"
        variant="primary">
        {{ $t('organization.add_member') }}
      </b-button>
    </b-form>
  </div>
</template>

<script>

import MemberTable from '../../components/organizations/MemberTable';
import VueMarkdown from 'vue-markdown';

export default {
	components: {
		MemberTable,
		VueMarkdown
	},
	data() {
		return {
			organization: {},
			newMemberUsername: null
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

	}
};
</script>
