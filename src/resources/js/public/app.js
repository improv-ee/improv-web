require('../bootstrap');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';
import Notifications from 'vue-notification'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'
import routes from './routes'
import Event from './components/schedule-feed/Event';
import App from './App';

import { dom, library } from '@fortawesome/fontawesome-svg-core'
import {faCalendar, faAddressCard} from "@fortawesome/free-regular-svg-icons";
import { faChevronRight  } from '@fortawesome/free-solid-svg-icons'
library.add(faCalendar, faChevronRight, faAddressCard);
dom.watch();

Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(BootstrapVue);

Vue.component('schedule-feed-event', Event);


const router = new VueRouter({
    mode: 'hash',
    routes: routes,
});

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
