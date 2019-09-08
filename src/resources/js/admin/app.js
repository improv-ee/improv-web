import {translationsEt} from '../../lang/et/admin';
import {translationsEn} from '../../lang/en/admin';

require('../bootstrap');
import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import datePicker from 'vue-bootstrap-datetimepicker';
import Notifications from 'vue-notification';
import VueRouter from 'vue-router';
import {getRoutes} from './routes';
import BootstrapVue from 'bootstrap-vue';
import App from './App';
import LoadingSpinner from '../components/LoadingSpinner';
import ProductionTableRow from './components/productions/ProductionTableRow';
import ProductionForm from './components/productions/Form';
import EventForm from './components/events/Form';
import LaravelVuePagination from 'laravel-vue-pagination';
import CrudToolbar from './components/CrudToolbar';
import VueProgressBar from 'vue-progressbar';

// Font Awesome bits
import { dom, library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faClock, faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck, faMapMarkerAlt, faFlagCheckered } from '@fortawesome/free-solid-svg-icons';
import {faCalendar,faTrashAlt,faTimesCircle,faEdit} from '@fortawesome/free-regular-svg-icons';
library.add(faClock, faCalendar,faArrowUp,faArrowDown,faChevronLeft,faChevronRight,faCalendarCheck,faMapMarkerAlt,faTrashAlt,faTimesCircle, faEdit, faFlagCheckered);
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
Vue.component('loading-spinner', LoadingSpinner);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);


const progressBarOptions = {
    color: '#007bff',
    failedColor: '#CC0000',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top'
};

Vue.use(VueProgressBar, progressBarOptions);
jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
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


const messages = {
    'en': translationsEn,
    'et': translationsEt,
};
const i18n = new VueI18n({
    locale: 'et',
    fallbackLocale: 'et',
    messages
});


const router = new VueRouter({
    mode: 'hash',
    routes: getRoutes(i18n)
});

function setI18nLanguage (lang) {

    // eslint-disable-next-line no-console
    console.debug('Setting locale to ' + lang);

    i18n.locale = lang;
    window.axios.defaults.headers.common['Accept-Language'] = lang;
    moment.locale(lang);
    document.querySelector('html').setAttribute('lang', lang);

    // Set a default query param to all API calls - the language.
    // This param has no practical effect (the API takes it's language from HTTP Accept-Language header)
    // but adding the query param will make the full URI of a resource unique per language.
    // We need this for cache busting - to make sure a resource of a correct language is returned to the requester
    // We have CloudFlare in front of us and CloudFlare does not honor the Vary header for caching. Sad.
    window.axios.defaults.params = {lang: lang};

    return lang;
}

// eslint-disable-next-line no-console
console.log('Initializing Vue...');

// Set language
setI18nLanguage(window.config.languages.current);

window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.config.token;

new Vue({
    el: '#app',
    render: createElement => createElement(App),
    router,
    i18n
});
