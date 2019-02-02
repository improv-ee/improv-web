<template>

    <div class="card h-100 mb-4 shadow-sm event-card">
        <div class="view overlay">
            <router-link :to="{ name: 'events', params: { uid: event.uid }}">
                <img class="card-img-top flex-auto"
                     :src="header_img(event.production.images)"
                     :alt="event.production.slug"/>
                <div class="mask rgba-white-slight"></div>
            </router-link>
        </div>

        <!-- Button -->
        <a class="btn-floating btn-action ml-auto mr-4"><span><i class="fas fa-chevron-right pl-1"></i></span></a>

        <div class="card-body align-items-start">

            <router-link :to="{ name: 'events', params: { uid: event.uid }}"><h4 class="mb-0">
                {{ title }}
            </h4></router-link>
            <p class="card-text mb-auto">{{ excerpt }}</p>
        </div>


        <div class="rounded-bottom deep-purple pt-3">
            <ul class="list-unstyled list-inline font-small">
                <li class="list-inline-item"><i class="far fa-calendar"></i> {{ start_time }}</li>
            </ul>
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
            },
            title: function(){
                if (this.event.title){
                    return this.event.title;
                }
                return this.event.production.title;
            },
            excerpt: function () {
                if (this.event.production.excerpt) {
                    return this.event.production.excerpt;
                }

                if (this.event.description) {
                    return _.truncate(this.event.description, {length: 200})
                }
                if (this.event.production.description) {
                    return _.truncate(this.event.production.description, {length: 200})
                }
            }
        },
        methods: {
            header_img(images) {
                return images.header ? images.header.urls.original : '/img/production/default-header.jpg';
            }
        }
    }
</script>
