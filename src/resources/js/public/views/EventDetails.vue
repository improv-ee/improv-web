<template>
  <div
    v-if="production.uid && event.uid"
    class="event-details">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <img
          class="img-fluid header-img"
          :src="header_img"
          :alt="event.production.uid">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-calendar" /> {{ $t('event.attr.start_time') }}</span><br>
          <span class="meta-value">{{ startTime }}</span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-calendar" /> {{ $t('event.attr.end_time') }}</span><br>
          <span class="meta-value">{{ endTime }}</span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta">
        <p>
          <span class="meta-label">
            <i class="far fa-address-card" /> {{ $t('event.attr.organizers') }}</span><br>
          <span class="meta-value">
            <ul class="list-inline">
              <li
                v-for="organization in production.organizations"
                :key="organization.uid">
                <router-link :to="{name: 'organization.details', params: {uid: organization.uid}}">{{ organization.name }}</router-link>
              </li>
            </ul>
          </span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta">
        <p
          v-if="event.place">
          <span class="meta-label">
            <i class="fas fa-map-marker-alt" /> {{ $t('event.attr.place') }}</span><br>
          <span class="meta-value">
            <a
              :href="event.place.url"
              :title="event.place.address"
              target="_blank">{{ event.place.name }}</a>
          </span>
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12">
        <h1>{{ title }}</h1>
        <vue-markdown :source="description" />
      </div>
    </div>
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
            event: {},
            production: {}
        };
    },
    computed: {
        title: function(){
            if (this.event.title !== null){
                return this.event.title;
            }
            return this.production.title;
        },
        description: function(){
            if (this.event.description !== null){
                return this.event.description;
            }
            return this.production.description;
        },
        header_img() {
            return this.production.images && this.production.images.header && this.production.images.header.urls.original != null ? this.production.images.header.urls.original : '/img/production/default-header.jpg';
        },
        startTime: function () {
            return moment(this.event.times.start).format('Do MMMM HH:mm');
        },
        endTime: function () {
            return moment(this.event.times.end).format('HH:mm');
        }
    },
    created() {
        axios.get(config.apiUrl + '/events/' + this.$route.params.uid)
            .then(response => {
                this.event = response.data.data;
                this.loadProduction(this.event.production.uid);
            });
    },
    methods: {
        loadProduction: function (uid) {
            axios.get(config.apiUrl + '/productions/' + uid)
                .then(response => {
                    this.production = response.data.data;
                });
        }
    },
    metaInfo () {
        return {
            title: this.title,
            meta: [
                {property: 'og:image', content: this.header_img},
                {property: 'og:description', content: this.description},
                {property: 'og:title', content: this.title + ' - ' + this.$t('app.name')},
            ]
        };
    }
};
</script>
