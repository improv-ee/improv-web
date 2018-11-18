
window._ = require('lodash');
window.Popper = require('popper.js').default;

window.Vue = require('vue');

import * as Sentry from '@sentry/browser'
Sentry.init({
    dsn: 'https://8afd4526c39647f7b9a1868fe6bfa55a@sentry.io/265079',
    integrations: [new Sentry.Integrations.Vue({ Vue })]
});

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function errorResponseHandler(error) {


    if( error.config.hasOwnProperty('errorHandle') && error.config.errorHandle === false ) {
        return Promise.reject(error);
    }

    if (error.response) {

        Vue.notify({
            type: 'error',
            group: 'app',
            title: 'Error communicating with the server',
            text: error.response.data.message
        });
    }
}
window.axios.interceptors.response.use(
    response => response,
    errorResponseHandler
);


window.moment = require('moment');
moment.locale('et');

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
