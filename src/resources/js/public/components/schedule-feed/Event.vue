<template>

    <div class="card mb-4 shadow-sm event-card">
        <router-link :to="{ name: 'events', params: { uid: event.uid }}">
                <img class="card-img-top flex-auto d-none d-lg-block"
                     :src="header_img(event.production.images)"
                     :alt="event.production.slug" />
        </router-link>
            <div class="card-body align-items-start">

                <router-link :to="{ name: 'events', params: { uid: event.uid }}"><h4 class="mb-0">
                    {{ event.production.title }}
                </h4></router-link>
                <div class="mb-1 text-muted">{{ start_time }}</div>
                <p class="card-text mb-auto">{{ event.production.excerpt }}</p>
            </div>

    </div>
</template>

<script>
    var moment = require('moment');
    moment.locale('et');

    export default {
        props: ['event'],
        computed: {
            start_time: function () {
                return moment(this.event.times.start).format('Do MMMM HH:mm')
            }

            },
        methods: {
            header_img(images) {
                return images.hasOwnProperty('header') ? images.header.url : '/img/production/default-header.jpg';
            }
        }
    }
</script>
