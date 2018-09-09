
require('../bootstrap');

window.Vue = require('vue');

import VueI18n from 'vue-i18n/dist/vue-i18n.js';

import VueRouter from 'vue-router'
Vue.use(VueRouter);

import Home from './views/Home.vue'
import ProductionsList from './views/productions/List.vue'
import ProductionDetails from './views/productions/Details.vue'


Vue.component('production-table-row', require('./components/productions/ProductionTableRow.vue'));

Vue.component('pagination', require('laravel-vue-pagination'));

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
            path: '/productions/:slug',
            name: 'production.details',
            component: ProductionDetails,
        },
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
