<template>
  <div
    v-if="production.getUid() && event.getUid()"
    class="event-details">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <img
          class="img-fluid header-img"
          :src="event.getHeaderImgUrl()"
          :alt="event.production.getUid()">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-calendar" /> {{ $t('event.attr.start_time') }}</span><br>
          <span class="meta-value">{{ event.getStartTimeHuman() }}</span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-calendar" /> {{ $t('event.attr.end_time') }}</span><br>
          <span class="meta-value">{{ event.getEndTimeHuman() }}</span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-address-card" /> {{ $t('event.attr.organizers') }}</span><br>
          <span class="meta-value">
            <ul class="list-inline">
              <li
                v-for="organization in production.getOrganizations()"
                :key="organization.uid">
                <router-link :to="{name: 'organization.details', params: {uid: organization.uid}}">{{ organization.name }}</router-link>
              </li>
            </ul>
          </span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta">
        <p
          v-if="event.hasPlace()">
          <span class="meta-label">
            <i class="fas fa-map-marker-alt" /> {{ $t('event.attr.place') }}</span><br>
          <span class="meta-value">
            <a
              :href="event.getPlace().url"
              :title="event.getPlace().address"
              target="_blank">{{ event.getPlace().name }}</a>
          </span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12">
        <h1>{{ event.getTitle() }}</h1>
        <vue-markdown :source="event.getDescription()" />
      </div>
    </div>
  </div>
</template>

<script>
import VueMarkdown from 'vue-markdown';
import {Event} from '../../models/event';
import {Production} from '../../models/production';
export default {
    components: {
        VueMarkdown
    },
    data() {
        return {
            event: new Event(),
            production: new Production()
        };
    },
    created() {
        axios.get(config.apiUrl + '/events/' + this.$route.params.uid)
            .then(response => {
                this.event = new Event(response.data.data);
                this.loadProduction(this.event.getProductionUid());
            });
    },
    methods: {
        loadProduction: function (uid) {
            axios.get(config.apiUrl + '/productions/' + uid)
                .then(response => {
                    this.production = new Production(response.data.data);
                    this.event.setProduction(this.production);
                });
        }
    }
};
</script>
