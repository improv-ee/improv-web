<template>
  <div>
    <loading-spinner v-if="events.length === 0" />
    <div v-else>
      <div class="row mb-2">
        <div
          v-for="event in events.data"
          :key="event.uid"
          class="col-12 col-md-6 col-lg-6 mb-3">
          <schedule-feed-event :event="eventFactory(event)" />
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
import {Event} from '../../models/event';
import {Production} from '../../models/production';
export default {
    data() {
        return {
            events: []
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {
        eventFactory(eventData){
            return new Event(eventData, new Production(eventData.production));
        },
        getResults(page = 1) {
            this.$Progress.start();

            axios.get(config.apiUrl + '/events/schedule', {params: {page: page}})
                .then(response => {
                    this.events = response.data;
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
