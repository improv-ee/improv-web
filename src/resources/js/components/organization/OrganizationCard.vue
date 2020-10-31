<template>
  <div>
    <div class="row">
      <div class="col-8 offset-2">
        <router-link :to="{name: 'organization.details', params: {uid: organization.getUid()}}">
          <b-img-lazy
            :src="organization.getHeaderImgUrl()"
            :blank-src="organization.getHeaderImgPlaceholder()"
            :srcset="organization.getHeaderImgSrcset()"
            class="rounded mx-auto d-block img-fluid"
            :alt="organization.getName()" />
        </router-link>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-4 offset-2">
        <p>
          <strong>{{ $t('organization.attr.name') }}:</strong>
          <router-link :to="{name: 'organization.details', params: {uid: organization.getUid()}}">
            {{ organization.getName() }}
          </router-link>
        </p>
      </div>
      <div class="col-4">
        <p v-if="organization.hasHomepage()">
          <strong> {{ $t('organization.attr.homepage_url') }}</strong>: <a
            :href="organization.getHomepageUrl()"
            target="_blank">{{ organization.getHomepageUrl(true) }}</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { Organization } from '../../models/organization';
export default {
    props: {
        organization: {
            type: Object,
            default: function () {
                return new Organization();
            }
        }
    }
};
</script>

<style scoped>
  img {
    width: 100%;
    cursor: pointer;
    margin-bottom: .5em;
  }
</style>
