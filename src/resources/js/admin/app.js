
require('../bootstrap');

window.Vue = require('vue');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import datePicker from 'vue-bootstrap-datetimepicker';

import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faClock, faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck  } from '@fortawesome/free-solid-svg-icons'
import {faCalendar,faTrashAlt,faTimesCircle} from '@fortawesome/free-regular-svg-icons'

library.add(faClock, faCalendar,faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck,faTrashAlt,faTimesCircle);


Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(datePicker);

import Home from './views/Home.vue'
import ProductionsList from './views/productions/List.vue'
import ProductionDetails from './views/productions/Details.vue'
import ProductionEdit from './views/productions/Edit.vue'
import EventDetails from './views/events/Details.vue'
import EventEdit from './views/events/Edit.vue'


Vue.component('production-table-row', require('./components/productions/ProductionTableRow.vue'));
Vue.component('production-form', require('./components/productions/Form.vue'));
Vue.component('event-form', require('./components/events/Form.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

$.extend(true, $.fn.datetimepicker.defaults, {
    locale: 'et',
    icons: {
        time: 'fas fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-check',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle'
    }
});

const router = new VueRouter({
    mode: 'hash',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/productions',
            name: 'productions',
            component: ProductionsList,
        },
        {
            path: '/events/:uid',
            name: 'event.details',
            component: EventDetails,
        },
        {
            path: '/events/:uid/edit',
            name: 'event.edit',
            component: EventEdit,
        },
        {
            path: '/productions/:slug',
            name: 'production.details',
            component: ProductionDetails,
        },{
            path: '/productions/:slug/edit',
            name: 'production.edit',
            component: ProductionEdit,
        }
    ]
});

const messages = require('../../lang/frontend.json');
const i18n = new VueI18n({    locale: 'et',    messages});

const app = new Vue({
    el: '#app',
    render: createElement => createElement(require('./App.vue')),
    router,
    i18n
});
