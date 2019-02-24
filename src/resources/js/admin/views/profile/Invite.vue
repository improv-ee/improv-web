<template>
  <div class="row">
    <side-nav />
    <div class="col-10">
      <h1>{{ $t('user.profile.invite.invite_new_user') }}</h1>
      <b-form @submit.prevent="inviteUser">
        <b-form-group
          :label="$t('user.profile.email')"
          label-for="email">
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            required />
        </b-form-group>
        <b-button
          type="submit"
          variant="primary"
          class="btn-block">
          {{
            $t('user.profile.invite.send_invitation') }}
        </b-button>
      </b-form>
    </div>
  </div>
</template>

<script>
import SideNav from '../../components/profile/SideNav';

export default {
	components: {
		SideNav
	},
	data() {
		return {
			form: {
				email: ''
			}
		};
	},
	methods: {
		inviteUser() {
			let self = this;
			axios.post(config.apiUrl + '/user/invite', this.form)
				.then(function () {

					self.$notify({
						type: 'success',
						group: 'app',
						title: self.$t('user.profile.invite.invite_sent')
					});

					self.form.email = null;
				}).catch(function (error) {

					let text = error.response.status === 422 ? self.$t('ui.validation_error') : self.$t('ui.server_error_message');

					self.$notify({
						type: 'error',
						group: 'app',
						title: self.$t('ui.server_error'),
						text: text
					});

				});
		}
	}
};
</script>
