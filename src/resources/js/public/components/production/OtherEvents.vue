<template>
    <div class="row" v-if="production.loaded() && production.getEvents().length > 1">
      <div class="col-md-12 col-lg-12">
        <h1>{{ $t('production.events') }}</h1>
        <router-link
                v-for="event in production.getEvents()"
                :key="event.uid"
                class="btn btn-primary"
                :to="{name: 'events', params: {uid: event.getUid()}}">
          {{ event.getStartTimeHuman() }}
        </router-link>
      </div>
  </div>
</template>

<script>
    import {Production} from '../../../models/production';
    export default {

        props: {
            production: {
                type: Object,
                default: function () {
                    return new Production();
                }
            }
        }
    };
</script>
