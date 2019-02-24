<template>
  <div v-if="organization.slug">
    <h1>{{ organization.name }}</h1>
    <img
      v-if="hasHeaderImage"
      :src="organization.images.header.urls.original"
      :alt="organization.image"
      class="img-responsive header-img">

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
