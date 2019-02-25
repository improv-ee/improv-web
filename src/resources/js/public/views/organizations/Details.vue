<template>
  <div v-if="organization.slug">
    <h1>{{ organization.name }}</h1>
    <img
      v-if="hasHeaderImage"
      :src="organization.images.header.urls.original"
      :alt="organization.image"
      class="img-responsive header-img">

    <div class="row">
      <div
        v-if="organization.email"
        class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-envelope-open" /> {{ $t('organization.attr.email') }}</span><br>
          <span class="meta-value">{{ organization.email }}</span>
        </p>
      </div>
      <div
        v-if="organization.urls.homepage"
        class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="fas fa-external-link-alt" /> {{ $t('organization.attr.homepage_url') }}</span><br>
          <span class="meta-value">
            <a
              :href="organization.urls.homepage"
              target="_blank">{{ organization.urls.homepage }}</a></span>
        </p>
      </div>
      <div
        v-if="organization.urls.facebook"
        class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="fab fa-facebook" /> {{ $t('organization.attr.facebook_url') }}</span><br>
          <span class="meta-value"><a
            :href="organization.urls.facebook"
            target="_blank">{{ organization.urls.facebook }}</a></span>
        </p>
      </div>
    </div>

    <vue-markdown :source="organization.description" />
  </div>
</template>

<script>

import VueMarkdown from 'vue-markdown';

export default {
	components: {
		VueMarkdown
	},
	data() {
		return {
			organization: {}
		};
	},
	computed: {
		hasHeaderImage: function () {
			return this.organization.images && this.organization.images.header && this.organization.images.header.urls && this.organization.images.header.urls.original;
		}
	},

	mounted() {
		this.loadOrganization();
	},
	methods: {
		loadOrganization() {
			let self = this;
			axios.get(config.apiUrl + '/organizations/' + this.$route.params.slug)
				.then(response => {
					self.organization = response.data.data;
				});
		}

	},
	metaInfo() {
		return {
			title: this.organization.name,
			meta: [
				{
					property: 'og:image',
					content: this.hasHeaderImage ? this.organization.images.header.urls.original : null
				},
				{property: 'og:description', content: this.organization.description},
				{property: 'og:title', content: this.organization.name + ' - ' + this.$t('app.name')},
			]
		};
	}
};
</script>
