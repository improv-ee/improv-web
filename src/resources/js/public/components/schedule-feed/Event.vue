<template>
  <div class="card h-100 mb-4 shadow-sm event-card">
    <div class="view overlay">
      <router-link :to="{ name: 'events', params: { uid: event.getUid() }}">
        <b-img-lazy
          class="card-img-top flex-auto"
          :blank-src="event.getHeaderImgPlaceholder()"
          :src="event.getHeaderImgUrl()"
          :srcset="event.getHeaderImgSrcset()"
          :alt="event.getTitle()" />

        <div class="mask rgba-white-slight" />
      </router-link>
    </div>

    <!-- Button -->
    <router-link
      :to="{ name: 'events', params: { uid: event.getUid() }}"
      class="btn-floating btn-action ml-auto mr-4">
      <span><i class="fas fa-chevron-right pl-1" /></span>
    </router-link>

    <div class="card-body align-items-start">
      <router-link :to="{ name: 'events', params: { uid: event.getUid() }}">
        <h4 class="mb-0">
          {{ event.getTitle() }}
        </h4>
      </router-link>
      <p class="card-text mb-auto">
        {{ event.production.getExcerpt() }}
      </p>
    </div>

    <div class="rounded-bottom mdb-color lighten-2">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <i class="far fa-calendar" /> {{ event.getStartTimeHuman() }}
          </div>
        </div>
      </div>
      <div
        v-if="event.getProduction().hasTags()"
        class="row">
        <div class="col-12 event-tags">
          <span
            v-for="tag in event.getProduction().getTags()"
            :key="tag.slug"
            class="badge badge-primary">
            {{ tag.name }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {Event} from '../../../models/event';
export default {
    props: {
        event: {
            type: Object,
            default: function () {
                return new Event();
            }
        }
    }
};
</script>
