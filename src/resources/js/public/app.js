require('../bootstrap');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import Notifications from 'vue-notification'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'
import routes from './routes'
import Event from './components/schedule-feed/Event';
import App from './App';
import VueAnalytics from 'vue-analytics'
import Meta from 'vue-meta';
import VueProgressBar from 'vue-progressbar';

import { dom, library } from '@fortawesome/fontawesome-svg-core'
import {faCalendar, faAddressCard, faTimesCircle} from "@fortawesome/free-regular-svg-icons";
import { faChevronRight  } from '@fortawesome/free-solid-svg-icons'
library.add(faCalendar, faChevronRight, faAddressCard,faTimesCircle);
dom.watch();

Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(BootstrapVue);
Vue.use(Meta);

Vue.component('schedule-feed-event', Event);

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


const router = new VueRouter({
    mode: 'hash',
    routes: routes,
});
Vue.use(VueAnalytics, {id: 'UA-133334351-1', router});


const messages = _.merge(require('../../lang/et/public.json'), require('../../lang/et/common.json'));
const i18n = new VueI18n({    locale: 'et',    messages});


function bootApp() {

    // Wait for async Axios request to load app config...
    if (!window.config) {
        setTimeout(bootApp, 50);
        return
    }
    console.log('Initializing app...');

    new Vue({
        el: '#app',
        render: createElement => createElement(App),
        router,
        i18n
    });
}

bootApp();
