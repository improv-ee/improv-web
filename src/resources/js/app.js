

require('./bootstrap');

window.Vue = require('vue');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';

import VueRouter from 'vue-router'
Vue.use(VueRouter);


Vue.component('schedule-feed-event', require('./components/schedule-feed/Event.vue'));

import EventSchedule from './views/EventSchedule.vue'
import EventDetails from './views/EventDetails.vue'
import Newsletter from './views/Newsletter.vue'

const router = new VueRouter({
    mode: 'hash',
    routes: [
        {
            path: '/',
            name: 'home',
            component: EventSchedule
        },
        {
            path: '/events/:uid',
            name: 'events',
            component: EventDetails,
        },
        {
            path: '/newsletter',
            name: 'newsletter',
            component: Newsletter,
        },
    ],
});

const messages = require('../lang/frontend.json');
const i18n = new VueI18n({    locale: 'et',    messages});

const app = new Vue({
    el: '#app',
    render: createElement => createElement(require('./App.vue')),
    router,
    i18n
});
