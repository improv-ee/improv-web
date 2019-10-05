<template>
  <div>
    <loading-spinner v-if="events.length === 0" />
    <div v-else>
      <div class="row">
        <div
          v-for="event in featuredEvents"
          :key="event.uid"
          class="col-12 col-md-6 mb-5">
          <schedule-feed-event :event="event" />
        </div>
      </div>
      <div class="row mb-2">
        <div
          v-for="event in events.data"
          :key="event.uid"
          class="col-12 col-md-6 col-lg-4 mb-3">
          <schedule-feed-event :event="event" />
        </div>
      </div>
      <div class="row">
        <div class="col-4 offset-4">
          <pagination
            v-if="events.meta"
            :data="events.meta"
            :show-disabled="true"
            class="justify-content-center"
            @pagination-change-page="getResults" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            events: [],
            featuredEvents: []
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {

        getResults(page = 1) {
            this.$Progress.start();

            axios.get(config.apiUrl + '/events/schedule', {params: {page: page}})
                .then(response => {
                    this.events = response.data;
                    this.featuredEvents = this.events.data.splice(0, 2);
                    this.loaded = true;
                    this.$Progress.finish();

                })
                .catch(error => {
                    // eslint-disable-next-line no-console
                    console.error(error);
                    window.location.href = '/maintenance';
                });
        }
    },
    metaInfo() {
        return {
            title: this.$t('nav.schedule')
        };
    }
};
</script>
