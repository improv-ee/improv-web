require('../bootstrap');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import Notifications from 'vue-notification'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'
import routes from './routes'

import { dom, library } from '@fortawesome/fontawesome-svg-core'
import {faCalendar, faAddressCard} from "@fortawesome/free-regular-svg-icons";
import { faChevronRight  } from '@fortawesome/free-solid-svg-icons'
library.add(faCalendar, faChevronRight, faAddressCard);
dom.watch();

Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(BootstrapVue);

Vue.component('schedule-feed-event', require('./components/schedule-feed/Event.vue').default);


const router = new VueRouter({
    mode: 'hash',
    routes: routes,
});

const messages = _.merge(require('../../lang/et/public.json'), require('../../lang/et/common.json'));
const i18n = new VueI18n({    locale: 'et',    messages});

const app = new Vue({
    el: '#app',
    render: createElement => createElement(require('./App.vue')),
    router,
    i18n
});
