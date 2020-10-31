<template>
  <div
    v-if="event.getUid() && event.getProduction().getUid()"
    class="event-details">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <b-img-lazy
          class="img-fluid header-img"
          :blank-src="event.getHeaderImgPlaceholder()"
          :src="event.getHeaderImgUrl()"
          :srcset="event.getHeaderImgSrcset()"
          :alt="event.getTitle()" />
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
              href="#"
              :title="event.getPlace().address"
              @click="toggleStaticMap">{{ event.getPlace().name }}</a>
          </span>
        </p>
      </div>
    </div>

    <transition
      name="fade">
      <div
        v-if="event.hasPlace() && showStaticMap"
        class="row align-items-center">
        <div class="col-8">
          <a
            :href="event.getPlace().urls.maps"
            target="_blank"
            :title="event.getPlace().address">
            <img
              :src="event.getPlace().urls.staticImage"
              :alt="event.getPlace().name"
              class="rounded map-image">
          </a>
        </div>
        <div class="col-4">
          <p>
            <strong>{{ event.getPlace().name }}</strong><br>
            {{ event.getPlace().address }}
          </p>
          <p>
            <a
              :href="event.getPlace().urls.maps"
              target="_blank"
              class="btn btn-primary btn-block">
              <i
                class="fas fa-map-marker-alt" /> {{ $t('event.attr.view_venue_map') }}
            </a>
          </p>
        </div>
      </div>
    </transition>

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
            event: new Event(new Production()),
            production: new Production(),
            showStaticMap: false
        };
    },
    created() {
        axios.get(config.apiUrl + '/events/' + this.$route.params.uid)
            .then(response => {
                this.event = new Event(response.data.data, new Production());
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
        },
        toggleStaticMap: function () {
            this.showStaticMap = !this.showStaticMap;
        }
    },
    metaInfo() {
        return {
            title: this.event.getTitle()
        };
    }
};
</script>
