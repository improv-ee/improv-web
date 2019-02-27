<template>
  <div v-if="organization.getName()">
    <h1>{{ organization.getName() }}</h1>
    <img
      v-if="organization.hasHeaderImg()"
      :src="organization.getHeaderImgUrl()"
      :alt="$t('organization.image')"
      class="img-responsive header-img">

    <div class="row">
      <div
        v-if="organization.getEmail()"
        class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-envelope-open" /> {{ $t('organization.attr.email') }}</span><br>
          <span class="meta-value">{{ organization.getEmail() }}</span>
        </p>
      </div>
      <div
        v-if="organization.getHomepageUrl()"
        class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="fas fa-external-link-alt" /> {{ $t('organization.attr.homepage_url') }}</span><br>
          <span class="meta-value">
            <a
              :href="organization.getHomepageUrl()"
              target="_blank">{{ organization.getHomepageUrl() }}</a></span>
        </p>
      </div>
      <div
        v-if="organization.getFacebookUrl()"
        class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="fab fa-facebook" /> {{ $t('organization.attr.facebook_url') }}</span><br>
          <span class="meta-value"><a
            :href="organization.getFacebookUrl()"
            target="_blank">{{ organization.getFacebookUrl() }}</a></span>
        </p>
      </div>
    </div>

    <vue-markdown :source="organization.getDescription()" />
  </div>
</template>

<script>

import VueMarkdown from 'vue-markdown';
import { Organization } from '../../../models/organization';

export default {
	components: {
		VueMarkdown
	},
	data() {
		return {
			organization: new Organization()
		};
	},
	mounted() {
		this.loadOrganization();
	},
	methods: {
		loadOrganization() {
			let self = this;
			axios.get(config.apiUrl + '/organizations/' + this.$route.params.slug)
				.then(response => {
					self.organization = new Organization(response.data.data);
				});
		}

	},
	metaInfo() {
		return {
			title: this.organization.getName(),
			meta: [
				{
					property: 'og:image',
					content: this.organization.getHeaderImgUrl()
				},
				{property: 'og:description', content: this.organization.getDescription()},
				{property: 'og:title', content: this.organization.getName() + ' - ' + this.$t('app.name')},
			]
		};
	}
};
</script>
