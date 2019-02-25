<template>
  <div
    v-if="form.name"
    class="row">
    <div class="col-10 offset-1">
      <b-form @submit.prevent="onSubmit">
        <b-form-group
          :label="$t('organization.attr.name')"
          :invalid-feedback="invalidFeedback('name')"
          :state="getFieldState('name')"
          label-for="org-name">
          <b-form-input
            id="org-name"
            v-model="form.name"
            type="text"
            required />
        </b-form-group>

        <b-form-group
          label=""
          label-for="org-ispublic">
          <b-form-checkbox
            id="org-ispublic"
            v-model="form.is_public">
            {{ $t('organization.attr.is_public') }}
          </b-form-checkbox>
        </b-form-group>


        <b-form-group
          :label="$t('organization.attr.email')"
          :invalid-feedback="invalidFeedback('email')"
          :state="getFieldState('email')"
          label-for="org-email">
          <b-form-input
            id="org-email"
            v-model="form.email"
            type="email"
            maxlength="255" />
        </b-form-group>


        <b-form-group
          :label="$t('organization.attr.homepage_url')"
          :invalid-feedback="invalidFeedback('homepage_url')"
          :state="getFieldState('homepage_url')"
          label-for="org-homepage_url">
          <b-form-input
            id="org-homepage_url"
            v-model="form.homepage_url"
            type="text" />
        </b-form-group>


        <b-form-group
          :label="$t('organization.attr.facebook_url')"
          :invalid-feedback="invalidFeedback('facebook_url')"
          :state="getFieldState('facebook_url')"
          label-for="org-facebook_url">
          <b-form-input
            id="org-facebook_url"
            v-model="form.facebook_url"
            type="text" />
        </b-form-group>


        <b-form-group
          :label="$t('organization.image')"
          :invalid-feedback="invalidFeedback('images.header.content')"
          :state="getFieldState('images.header.content')"
          label-for="header-img">
          <div
            v-if="hasHeaderImage"
            class="overlay-container"
            @click="removeHeaderImg()">
            <img
              class="img-fluid"
              :src="form.images.header.urls.original"
              :alt="$t('organization.image')">
            <div class="img-overlay">
              <span><i class="far fa-trash-alt fa-10x" /></span>
            </div>
          </div>


          <b-form-file
            v-else
            accept="image/jpeg, image/png, image/webp"
            :placeholder="$t('production.img.select_file')"
            @change="uploadHeaderImg" />
        </b-form-group>


        <b-form-group
          :label="$t('organization.attr.description')"
          :invalid-feedback="invalidFeedback('description')"
          :state="getFieldState('description')"
          :description="$t('ui.markdown_supported')"
          label-for="org-description">
          <b-form-textarea
            id="org-description"
            v-model="form.description"
            type="text"
            rows="10"
            max-rows="30" />
        </b-form-group>


        <b-button
          type="submit"
          variant="primary"
          class="btn-block">
          {{ $t('ui.edit') }}
        </b-button>
      </b-form>
    </div>
  </div>
</template>

<script>
export default {
	data() {
		return {
			organization: {},
			form: {},
			errors: {}
		};
	},
	computed: {
		hasHeaderImage: function () {
			return this.form.images && this.form.images.header && this.form.images.header.urls && this.form.images.header.urls.original;
		}
	},
	mounted() {
		axios.get(config.apiUrl + '/organizations/' + this.$route.params.slug)
			.then(response => {
				this.organization = response.data.data;
				this.form = {
					name: this.organization.name,
					description: this.organization.description,
					is_public: this.organization.is_public,
					facebook_url: this.organization.urls.facebook,
					homepage_url: this.organization.urls.homepage,
					email: this.organization.email,
					images: {
						header: {
							urls: {
								original: this.organization.hasOwnProperty('images') && this.organization.images.header !== null ? this.organization.images.header.urls.original : null
							}
						}
					}
				};
			});
	},
	methods: {
		getFieldState(field) {
			return !this.errors.hasOwnProperty(field);
		},
		invalidFeedback(field) {
			if (!this.errors.hasOwnProperty(field) || !this.errors[field].length) {
				return '';
			}
			return this.errors[field][0];
		},
		removeHeaderImg() {
			this.form.images.header['content'] = this.form.images.header.urls = null;
		},
		fileToBase64(file) {
			return new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = () => resolve(reader.result);
				reader.onerror = error => reject(error);
			});
		},
		uploadHeaderImg(e) {
			let self = this;
			this.fileToBase64(e.srcElement.files[0]).then(data => self.form.images = {header: {content: data}});
		},

		onSubmit() {
			let self = this;

			axios.put(config.apiUrl + '/organizations/' + this.$route.params.slug, this.form)
				.then(function (response) {

					self.$router.push({
						name: 'organization.details',
						params: {slug: response.data.data.slug}
					});
					self.errors = {};
				})
				.catch(function (error) {
					self.errors = error.response.data.errors;
				});
		}
	},

};
</script>
