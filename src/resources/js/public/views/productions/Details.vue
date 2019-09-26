<template>
  <div
    v-if="production.loaded()"
    class="event-details">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <img
          class="img-fluid header-img"
          :src="production.getHeaderImgUrl()"
          :alt="production.getUid()">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="fas fa-tags" /> {{ $t('event.attr.tags') }}</span><br>
          <span class="meta-value">
            <ul class="list-inline text-uppercase">
              <li
                v-for="tag in production.getTags()"
                :key="tag.slug"
                class="d-inline">
                {{ tag.name }}
              </li>
            </ul>
          </span>
        </p>
      </div>
      <div class="col-lg-6 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-address-card" /> {{ $t('event.attr.organizers') }}</span><br>
          <span class="meta-value">
            <ul class="list-inline">
              <li
                v-for="organization in production.getOrganizations()"
                :key="organization.uid"
                class="d-inline">
                <router-link :to="{name: 'organization.details', params: {uid: organization.uid}}">{{ organization.name }}</router-link>
              </li>
            </ul>
          </span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12">
        <h1>{{ production.getTitle() }}</h1>
        <vue-markdown :source="production.getDescription()" />
      </div>
    </div>

    <other-events :production="production" />
  </div>
</template>

<script>
import VueMarkdown from 'vue-markdown';
import {Production} from '../../../models/production';
import OtherEvents from '../../components/production/OtherEvents';

export default {
    components: {
        VueMarkdown,
        OtherEvents
    },
    data() {
        return {
            production: new Production()
        };
    },
    created() {
        axios.get(config.apiUrl + '/productions/' + this.$route.params.uid)
            .then(response => {
                this.production = new Production(response.data.data);
            });
    }
};
</script>
