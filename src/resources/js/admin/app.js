
require('../bootstrap');

window.Vue = require('vue');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';

import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.use(VueRouter);

import Home from './views/Home.vue'
import ProductionsList from './views/productions/List.vue'
import ProductionDetails from './views/productions/Details.vue'
import ProductionEdit from './views/productions/Edit.vue'


Vue.component('production-table-row', require('./components/productions/ProductionTableRow.vue'));
Vue.component('production-form', require('./components/productions/Form.vue'));
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
            path: '/productions/new',
            name: 'production.new',
            component: ProductionEdit,
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
