require('../bootstrap');

window.Vue = require('vue');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import Notifications from 'vue-notification'

import VueRouter from 'vue-router'
import routes from './routes'

Vue.use(VueRouter);
Vue.use(Notifications);

Vue.component('schedule-feed-event', require('./components/schedule-feed/Event.vue'));



const router = new VueRouter({
    mode: 'hash',
    routes: routes,
});

const messages = _.merge(require('../../lang/et/admin.json'),require('../../lang/et/common.json'));
const i18n = new VueI18n({    locale: 'et',    messages});

const app = new Vue({
    el: '#app',
    render: createElement => createElement(require('./App.vue')),
    router,
    i18n
});
