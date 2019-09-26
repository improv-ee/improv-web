import {translationsEt} from '../../lang/et/public';
import {translationsEn} from '../../lang/en/public';

require('../bootstrap');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import Notifications from 'vue-notification';
import BootstrapVue from 'bootstrap-vue';
import LoadingSpinner from '../components/LoadingSpinner';
import VueRouter from 'vue-router';
import {getRoutes} from './routes';
import Event from './components/schedule-feed/Event';
import App from './App';
import VueAnalytics from 'vue-analytics';
import Meta from 'vue-meta';
import VueProgressBar from 'vue-progressbar';
import LaravelVuePagination from 'laravel-vue-pagination';

import { dom, library } from '@fortawesome/fontawesome-svg-core';
import {faCalendar, faAddressCard, faTimesCircle, faEnvelopeOpen} from '@fortawesome/free-regular-svg-icons';
import { faChevronRight, faMapMarkerAlt, faExternalLinkAlt, faMicrophone, faTags } from '@fortawesome/free-solid-svg-icons';
import { faFacebook  } from '@fortawesome/free-brands-svg-icons';
library.add(faCalendar, faChevronRight, faAddressCard,faTimesCircle, faFacebook, faMicrophone, faMapMarkerAlt, faEnvelopeOpen,faExternalLinkAlt, faTags);
dom.watch();

Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(BootstrapVue);
Vue.use(Meta);

Vue.component('schedule-feed-event', Event);
Vue.component('pagination', LaravelVuePagination);
Vue.component('loading-spinner', LoadingSpinner);

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
    routes: getRoutes(i18n),
});
Vue.use(VueAnalytics, {id: 'UA-133334351-1', router});


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
console.log('Initializing app...');

// Set language
setI18nLanguage(window.config.languages.current);

new Vue({
    el: '#app',
    render: createElement => createElement(App),
    router,
    i18n
});
