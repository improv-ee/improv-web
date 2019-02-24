<template>
  <div class="row">
    <side-nav />
    <div class="col-10">
      <h1>{{ $t('user.profile.settings') }}</h1>

      <div class="row">
        <div class="col-10">
          <b-form>
            <b-form-group
              :label="$t('user.profile.name')"
              label-for="user-name">
              <b-form-input
                id="user-name"
                v-model="form.name"
                type="text"
                disabled
                :label="$t('user.profile.name')"
                required />
            </b-form-group>

            <b-form-group
              :label="$t('user.username')"
              label-for="user-username">
              <b-form-input
                id="user-username"
                v-model="form.username"
                type="text"
                disabled
                required />
            </b-form-group>
          </b-form>
        </div>
        <div class="col-2">
          <b-img
            v-if="form"
            :src="form.avatar"
            fluid
            :alt="$t('user.profile.avatar')" />
        </div>
      </div>
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
			form: {}
		};
	},
	mounted() {
		let self = this;
		axios.get(config.apiUrl + '/users/' + window.config.username)
			.then(response => {
				self.form = response.data.data;
			});
	}
};
</script>
