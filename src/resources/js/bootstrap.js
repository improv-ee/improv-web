/* eslint-disable no-console */

window._ = require('lodash');
window.Popper = require('popper.js').default;

window.Vue = require('vue');

import * as Sentry from '@sentry/browser';

Sentry.init({
    dsn: 'https://4b357e3a9aa347229d1f452bf469f676@sentry.io/1314907',
    integrations: [new Sentry.Integrations.Vue({Vue})],
    ignoreErrors: [
        '[vue-analytics]'
    ],
    whitelistUrls: [
        'https://improv.ee',
        'https://api.improv.ee'
    ],
    // https://docs.sentry.io/workflow/releases
    // Keep release in VCS at "improv-web@dev", this will be search-replaced
    // by Travis build (build-webserver.sh)
    release: 'improv-web@dev',
    beforeSend(event) {
        // Check if it is an exception, if so, show the report dialog
        console.error(event);
        if (event.exception && event.exception.mechanism.handled !== true) {
            Sentry.showReportDialog();
        }
        return event;
    }
});

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap');

require('mdbootstrap');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.moment = require('moment');
require('moment/locale/et');

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

console.log('Initializing app, requesting runtime config from backend...');
axios.get('/getConfig')
    .then(response => {
        window.config = response.data;
        console.info('Config loaded, API URL is ' + window.config.apiUrl + ', continuing with app init...');
    }).catch(function (error) {
        console.error('Fatal - unable to load app config!');
        console.error(error);
        window.location.href = '/maintenance';
    });
