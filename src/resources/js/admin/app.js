
require('../bootstrap');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import datePicker from 'vue-bootstrap-datetimepicker';
import Notifications from 'vue-notification'
import VueRouter from 'vue-router'
import routes from './routes'
import BootstrapVue from 'bootstrap-vue'

// Font Awesome bits
import { dom, library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faClock, faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck  } from '@fortawesome/free-solid-svg-icons'
import {faCalendar,faTrashAlt,faTimesCircle} from '@fortawesome/free-regular-svg-icons'
library.add(faClock, faCalendar,faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck,faTrashAlt,faTimesCircle);
dom.watch();


Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(datePicker);
Vue.use(Notifications);


Vue.component('production-table-row', require('./components/productions/ProductionTableRow'));
Vue.component('production-form', require('./components/productions/Form'));
Vue.component('event-form', require('./components/events/Form'));
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('crud-toolbar', require('./components/CrudToolbar'));

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
    routes: routes
});

const messages = _.merge(require('../../lang/et/admin.json'),require('../../lang/et/common.json'));
const i18n = new VueI18n({    locale: 'et',    messages});


// Global app config options
window.config = {
    'username': document.head.querySelector('meta[name="username"]').getAttribute('content'),
    'organization': {
        ROLE_ADMIN: 0
    }
};


const app = new Vue({
    el: '#app',
    render: createElement => createElement(require('./App.vue')),
    router,
    i18n
});
