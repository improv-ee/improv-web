<template>
  <div v-if="event.uid">
    <b-breadcrumb
      v-if="breadcrumbs"
      :items="breadcrumbs" />
    <crud-toolbar
      resource-name="events"
      :resource-id="$route.params.uid"
      :delete-redirect="{name: 'production.details', params: {uid: event.production.uid}}" />


    <h1>{{ event.title }}</h1>

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
            <i class="fas fa-map-marker-alt" /> {{ $t('event.attr.place') }}</span><br>
          <span class="meta-value">
            <a
              v-if="event.place"
              :href="event.place.url"
              :title="event.place.address"
              target="_blank">{{ event.place.name }}</a>
          </span>
        </p>
      </div>
      <div class="col-lg-3 col-object-meta" />
    </div>
    <div class="row">
      <div class="col-lg-12">
        <vue-markdown
          v-if="event.description"
          :source="event.description" />
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
            breadcrumbs: []
        };
    },
    computed: {
        startTime: function () {
            return moment(this.event.times.start).format('Do MMMM HH:mm');
        },
        endTime: function () {
            return moment(this.event.times.end).format('HH:mm');
        }
    },
    mounted() {
        axios.get(config.apiUrl + '/events/' + this.$route.params.uid)
            .then(response => {
                this.event = response.data.data;

                this.breadcrumbs = [
                    {
                        text: this.$t('nav.productions'),
                        to: { name: 'productions' }
                    },
                    {
                        text: this.event.production.title,
                        to: { name: 'production.details', params: {uid: this.event.production.uid } }
                    },
                    {
                        text: this.startTime,
                        to: { name: 'event.details', params: {uid: this.event.uid} }
                    },
                ];
            });

    }
};
</script>
