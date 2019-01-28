require('../bootstrap');
import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import datePicker from 'vue-bootstrap-datetimepicker';
import Notifications from 'vue-notification'
import VueRouter from 'vue-router'
import routes from './routes'
import BootstrapVue from 'bootstrap-vue'
import App from './App';
import ProductionTableRow from './components/productions/ProductionTableRow'
import ProductionForm from './components/productions/Form'
import EventForm from './components/events/Form'
import LaravelVuePagination from 'laravel-vue-pagination'
import CrudToolbar from './components/CrudToolbar'

// Font Awesome bits
import { dom, library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faClock, faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck  } from '@fortawesome/free-solid-svg-icons'
import {faCalendar,faTrashAlt,faTimesCircle,faEdit} from '@fortawesome/free-regular-svg-icons'
library.add(faClock, faCalendar,faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck,faTrashAlt,faTimesCircle, faEdit);
dom.watch();


Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(datePicker);
Vue.use(Notifications);


Vue.component('production-table-row', ProductionTableRow);
Vue.component('production-form', ProductionForm);
Vue.component('event-form', EventForm);
Vue.component('pagination', LaravelVuePagination);
Vue.component('crud-toolbar', CrudToolbar);

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


function bootApp() {

    // Wait for async Axios request to load app config...
    if (!window.config) {
        setTimeout(bootApp, 50);
        return
    }
    console.log('Initializing app...');

    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.config.token;

    new Vue({
        el: '#app',
        render: createElement => createElement(App),
        router,
        i18n
    });
}

bootApp();

