/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 258);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/moment/moment.js'");

/***/ }),

/***/ 11:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/jquery/dist/jquery.js'");

/***/ }),

/***/ 14:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/popper.js/dist/esm/popper.js'");

/***/ }),

/***/ 161:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_Vue, Vue, __webpack_provided_window_dot_jQuery, __webpack_provided_window_dot_moment, moment) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sentry_browser__ = __webpack_require__(458);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sentry_browser___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__sentry_browser__);

window._ = __webpack_require__(163);
window.Popper = __webpack_require__(14).default;

__webpack_provided_window_dot_Vue = __webpack_require__(9);


__WEBPACK_IMPORTED_MODULE_0__sentry_browser__["init"]({
    dsn: 'https://8afd4526c39647f7b9a1868fe6bfa55a@sentry.io/265079',
    integrations: [new __WEBPACK_IMPORTED_MODULE_0__sentry_browser__["Integrations"].Vue({ Vue: Vue })]
});

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = __webpack_provided_window_dot_jQuery = __webpack_require__(11);

    __webpack_require__(164);
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__(165);

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function errorResponseHandler(error) {

    if (error.config.hasOwnProperty('errorHandle') && error.config.errorHandle === false) {
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
window.axios.interceptors.response.use(function (response) {
    return response;
}, errorResponseHandler);

__webpack_provided_window_dot_moment = __webpack_require__(0);
moment.locale('et');

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(9), __webpack_require__(9), __webpack_require__(11), __webpack_require__(0), __webpack_require__(0)))

/***/ }),

/***/ 163:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/lodash/lodash.js'");

/***/ }),

/***/ 164:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/bootstrap/dist/js/bootstrap.js'");

/***/ }),

/***/ 165:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/axios/index.js'");

/***/ }),

/***/ 18:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/css-loader/lib/css-base.js'");

/***/ }),

/***/ 184:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue-i18n/dist/vue-i18n.js'");

/***/ }),

/***/ 185:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue-notification/dist/index.js'");

/***/ }),

/***/ 186:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue-router/dist/vue-router.esm.js'");

/***/ }),

/***/ 187:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = null
/* template */
var __vue_template__ = __webpack_require__(188)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/views/PageNotFound.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-444d8c86", Component.options)
  } else {
    hotAPI.reload("data-v-444d8c86", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 188:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-6 offset-3" }, [
      _c("h1", [_vm._v(_vm._s(_vm.$t("ui.page_not_found")))]),
      _vm._v(" "),
      _c("p", [_vm._v(_vm._s(_vm.$t("ui.page_not_found_description")))])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-444d8c86", module.exports)
  }
}

/***/ }),

/***/ 189:
/***/ (function(module, exports) {

module.exports = {"et":{"ui":{"create":"Sisesta","add_new":"Lisa uus","edit":"Muuda","cancel":"Katkesta","delete":"Kustuta","validation_error":"Sisendandmed ei sobi","page_not_found":"Lehte ei leitud","page_not_found_description":"Soovitud lehe avamine ebaõnnestus"}}}

/***/ }),

/***/ 201:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue-style-loader/lib/addStylesClient.js'");

/***/ }),

/***/ 232:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/@fortawesome/fontawesome-svg-core/index.es.js'");

/***/ }),

/***/ 258:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(259);


/***/ }),

/***/ 259:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function(Vue, $) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_i18n_dist_vue_i18n_js__ = __webpack_require__(184);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_i18n_dist_vue_i18n_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_i18n_dist_vue_i18n_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_bootstrap_datetimepicker__ = __webpack_require__(260);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_bootstrap_datetimepicker___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_bootstrap_datetimepicker__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_notification__ = __webpack_require__(185);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_notification___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue_notification__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vue_router__ = __webpack_require__(186);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vue_router___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_vue_router__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__routes__ = __webpack_require__(262);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_bootstrap_vue__ = __webpack_require__(293);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_bootstrap_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_bootstrap_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__fortawesome_fontawesome_svg_core__ = __webpack_require__(232);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__fortawesome_fontawesome_svg_core___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__fortawesome_fontawesome_svg_core__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__fortawesome_vue_fontawesome__ = __webpack_require__(406);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__fortawesome_vue_fontawesome___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__fortawesome_vue_fontawesome__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__ = __webpack_require__(407);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__fortawesome_free_regular_svg_icons__ = __webpack_require__(408);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__fortawesome_free_regular_svg_icons___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__fortawesome_free_regular_svg_icons__);

__webpack_require__(161);








// Font Awesome bits




__WEBPACK_IMPORTED_MODULE_6__fortawesome_fontawesome_svg_core__["library"].add(__WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__["faClock"], __WEBPACK_IMPORTED_MODULE_9__fortawesome_free_regular_svg_icons__["faCalendar"], __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__["faArrowUp"], __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__["faArrowDown"], __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__["faChevronLeft"], __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__["faChevronRight"], __WEBPACK_IMPORTED_MODULE_8__fortawesome_free_solid_svg_icons__["faCalendarCheck"], __WEBPACK_IMPORTED_MODULE_9__fortawesome_free_regular_svg_icons__["faTrashAlt"], __WEBPACK_IMPORTED_MODULE_9__fortawesome_free_regular_svg_icons__["faTimesCircle"]);
__WEBPACK_IMPORTED_MODULE_6__fortawesome_fontawesome_svg_core__["dom"].watch();

Vue.component('font-awesome-icon', __WEBPACK_IMPORTED_MODULE_7__fortawesome_vue_fontawesome__["FontAwesomeIcon"]);
Vue.use(__WEBPACK_IMPORTED_MODULE_5_bootstrap_vue__["default"]);
Vue.use(__WEBPACK_IMPORTED_MODULE_3_vue_router__["default"]);
Vue.use(__WEBPACK_IMPORTED_MODULE_1_vue_bootstrap_datetimepicker__["default"]);
Vue.use(__WEBPACK_IMPORTED_MODULE_2_vue_notification__["default"]);

Vue.component('production-table-row', __webpack_require__(409));
Vue.component('production-form', __webpack_require__(412));
Vue.component('event-form', __webpack_require__(415));
Vue.component('pagination', __webpack_require__(418));
Vue.component('crud-toolbar', __webpack_require__(419));

Vue.component('passport-clients', __webpack_require__(422));

Vue.component('passport-authorized-clients', __webpack_require__(428));

Vue.component('passport-personal-access-tokens', __webpack_require__(433));

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

var router = new __WEBPACK_IMPORTED_MODULE_3_vue_router__["default"]({
    mode: 'hash',
    routes: __WEBPACK_IMPORTED_MODULE_4__routes__["a" /* default */]
});

var messages = _.merge(__webpack_require__(438), __webpack_require__(189));
var i18n = new __WEBPACK_IMPORTED_MODULE_0_vue_i18n_dist_vue_i18n_js__["default"]({ locale: 'et', messages: messages });

var app = new Vue({
    el: '#app',
    render: function render(createElement) {
        return createElement(__webpack_require__(439));
    },
    router: router,
    i18n: i18n
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(9), __webpack_require__(11)))

/***/ }),

/***/ 260:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue-bootstrap-datetimepicker/dist/vue-bootstrap-datetimepicker.js'");

/***/ }),

/***/ 262:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__views_Home__ = __webpack_require__(263);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__views_Home___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__views_Home__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__views_PageNotFound__ = __webpack_require__(187);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__views_PageNotFound___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__views_PageNotFound__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__views_productions_List__ = __webpack_require__(266);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__views_productions_List___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__views_productions_List__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__views_productions_Details__ = __webpack_require__(269);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__views_productions_Details___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__views_productions_Details__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__views_productions_Edit__ = __webpack_require__(272);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__views_productions_Edit___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4__views_productions_Edit__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__views_events_Details__ = __webpack_require__(275);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__views_events_Details___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__views_events_Details__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__views_events_Edit__ = __webpack_require__(278);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__views_events_Edit___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__views_events_Edit__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__views_profile_Settings__ = __webpack_require__(281);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__views_profile_Settings___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__views_profile_Settings__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__views_organizations_List__ = __webpack_require__(284);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__views_organizations_List___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__views_organizations_List__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__views_organizations_Details__ = __webpack_require__(287);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__views_organizations_Details___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__views_organizations_Details__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__views_organizations_Edit__ = __webpack_require__(290);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__views_organizations_Edit___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__views_organizations_Edit__);












/* harmony default export */ __webpack_exports__["a"] = ([{
    path: '/',
    name: 'home',
    component: __WEBPACK_IMPORTED_MODULE_0__views_Home___default.a
}, {
    path: '/productions',
    name: 'productions',
    component: __WEBPACK_IMPORTED_MODULE_2__views_productions_List___default.a
}, {
    path: '/events/:uid',
    name: 'event.details',
    component: __WEBPACK_IMPORTED_MODULE_5__views_events_Details___default.a
}, {
    path: '/events/:uid/edit',
    name: 'event.edit',
    component: __WEBPACK_IMPORTED_MODULE_6__views_events_Edit___default.a
}, {
    path: '/productions/:slug',
    name: 'production.details',
    component: __WEBPACK_IMPORTED_MODULE_3__views_productions_Details___default.a
}, {
    path: '/productions/:slug/edit',
    name: 'production.edit',
    component: __WEBPACK_IMPORTED_MODULE_4__views_productions_Edit___default.a
}, {
    path: '/profile/settings',
    name: 'profile.settings',
    component: __WEBPACK_IMPORTED_MODULE_7__views_profile_Settings___default.a
}, {
    path: '/organizations',
    name: 'organizations',
    component: __WEBPACK_IMPORTED_MODULE_8__views_organizations_List___default.a
}, {
    path: '/organizations/:slug',
    name: 'organization.details',
    component: __WEBPACK_IMPORTED_MODULE_9__views_organizations_Details___default.a
}, {
    path: '/organizations/:slug/edit',
    name: 'organization.edit',
    component: __WEBPACK_IMPORTED_MODULE_10__views_organizations_Edit___default.a
}, { path: "*", component: __WEBPACK_IMPORTED_MODULE_1__views_PageNotFound___default.a }]);

/***/ }),

/***/ 263:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(264)
/* template */
var __vue_template__ = __webpack_require__(265)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/Home.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-87400184", Component.options)
  } else {
    hotAPI.reload("data-v-87400184", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 264:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ 265:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-6 offset-3" }, [
      _c("p", { staticClass: "lead" }, [
        _vm._v(
          "\n            " + _vm._s(_vm.$t("dash.greeting")) + "\n        "
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-87400184", module.exports)
  }
}

/***/ }),

/***/ 266:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(267)
/* template */
var __vue_template__ = __webpack_require__(268)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/productions/List.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d3ecdedc", Component.options)
  } else {
    hotAPI.reload("data-v-d3ecdedc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 267:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            productions: {},
            newProductionTitle: ' '
        };
    },

    methods: {
        createProduction: function createProduction(e) {
            e.preventDefault();
            if (!this.newProductionTitle) {
                return;
            }
            var self = this;
            axios.post('/api/productions', { "title": this.newProductionTitle }).then(function (response) {
                self.$router.push({
                    name: 'production.edit',
                    params: { slug: response.data.data.slug }
                });
            });
        },
        getResults: function getResults() {
            var _this = this;

            var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;

            axios.get('/api/productions', { params: { page: page } }).then(function (response) {
                _this.productions = response.data;
            });
        }
    },
    mounted: function mounted() {
        this.getResults();
    }
});

/***/ }),

/***/ 268:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("p", [
        _c("span", {
          domProps: { innerHTML: _vm._s(_vm.$t("production.list_intro")) }
        })
      ]),
      _vm._v(" "),
      _c(
        "p",
        { staticClass: "text-right" },
        [
          _c(
            "b-btn",
            {
              directives: [
                {
                  name: "b-modal",
                  rawName: "v-b-modal.modal-new-production",
                  modifiers: { "modal-new-production": true }
                }
              ],
              staticClass: "btn btn-sm btn-outline-secondary mb-3"
            },
            [_vm._v(_vm._s(_vm.$t("production.create_new")))]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c("table", { staticClass: "table table-hover table-clickable" }, [
          _c("thead", { staticClass: "thead-dark" }, [
            _c("tr", [
              _c("th", [_vm._v(_vm._s(_vm.$t("production.attr.title")))]),
              _vm._v(" "),
              _c("th", [_vm._v(_vm._s(_vm.$t("production.num_of_events")))])
            ])
          ]),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.productions.data, function(production) {
              return _c("production-table-row", {
                key: production.slug,
                attrs: { production: production }
              })
            })
          )
        ])
      ]),
      _vm._v(" "),
      _c("pagination", {
        staticClass: "justify-content-center",
        attrs: { data: _vm.productions.meta },
        on: { "pagination-change-page": _vm.getResults }
      }),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            id: "modal-new-production",
            title: _vm.$t("production.create_new"),
            "ok-title": _vm.$t("ui.create"),
            "cancel-title": _vm.$t("ui.cancel")
          },
          on: { ok: _vm.createProduction }
        },
        [
          _c(
            "b-form",
            {
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  return _vm.createProduction($event)
                }
              }
            },
            [
              _c(
                "b-form-group",
                {
                  attrs: {
                    label: _vm.$t("production.attr.title"),
                    "label-for": "title",
                    description: _vm.$t("production.attr.title_description")
                  }
                },
                [
                  _c("b-form-input", {
                    attrs: {
                      id: "title",
                      type: "text",
                      state: _vm.newProductionTitle.length > 0,
                      required: ""
                    },
                    model: {
                      value: _vm.newProductionTitle,
                      callback: function($$v) {
                        _vm.newProductionTitle =
                          typeof $$v === "string" ? $$v.trim() : $$v
                      },
                      expression: "newProductionTitle"
                    }
                  })
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-d3ecdedc", module.exports)
  }
}

/***/ }),

/***/ 269:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(270)
/* template */
var __vue_template__ = __webpack_require__(271)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/productions/Details.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-edc54c04", Component.options)
  } else {
    hotAPI.reload("data-v-edc54c04", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 270:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function(moment) {//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            production: {}
        };
    },

    methods: {
        formatTime: function formatTime(date) {
            return moment(date).format('Do MMMM HH:mm');
        },
        openEvent: function openEvent(uid) {
            this.$router.push({ name: 'event.details', params: { uid: uid } });
        },
        addEvent: function addEvent() {
            var self = this;
            axios.post('/api/events', {
                'production': { 'slug': this.$route.params.slug },
                'times': {
                    'start': moment().add(24, 'h').format(),
                    'end': moment().add(25, 'h').format()
                }
            }).then(function (response) {
                self.$router.push({
                    name: 'event.edit',
                    params: { uid: response.data.data.uid }
                });
            });
        }
    },
    mounted: function mounted() {
        var _this = this;

        axios.get('/api/productions/' + this.$route.params.slug).then(function (response) {
            _this.production = response.data.data;
        });
    }
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 271:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.production
    ? _c(
        "div",
        [
          _c("crud-toolbar", {
            attrs: {
              "resource-name": "productions",
              "resource-id": this.$route.params.slug
            }
          }),
          _vm._v(" "),
          _c("h1", [_vm._v(_vm._s(_vm.production.title))]),
          _vm._v(" "),
          _vm.production.images
            ? _c("img", {
                staticClass: "img-responsive header-img",
                attrs: {
                  src: _vm.production.images.header.url,
                  alt: _vm.production.title
                }
              })
            : _vm._e(),
          _vm._v(" "),
          _c("p", { staticClass: "lead" }, [
            _vm._v(_vm._s(_vm.production.excerpt))
          ]),
          _vm._v(" "),
          _c("p", [_vm._v(_vm._s(_vm.production.description))]),
          _vm._v(" "),
          _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table table-clickable" }, [
              _c("thead", [
                _c("tr", [
                  _c("th", [_vm._v(_vm._s(_vm.$t("production.attr.title")))]),
                  _vm._v(" "),
                  _c("th", [_vm._v(_vm._s(_vm.$t("event.attr.start_time")))])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.production.events, function(event) {
                  return _vm.production.events
                    ? _c(
                        "tr",
                        {
                          on: {
                            click: function($event) {
                              _vm.openEvent(event.uid)
                            }
                          }
                        },
                        [
                          _c("td", [
                            _vm._v(_vm._s(event.title || _vm.production.title))
                          ]),
                          _vm._v(" "),
                          _c("td", [
                            _vm._v(_vm._s(_vm.formatTime(event.times.start)))
                          ])
                        ]
                      )
                    : _c("tr", [
                        _c("td", { attrs: { colspan: "2" } }, [
                          _vm._v(_vm._s(_vm.$t("production.no_events")))
                        ])
                      ])
                })
              ),
              _vm._v(" "),
              _c("tfoot", [
                _c("tr", [
                  _c(
                    "td",
                    { attrs: { colspan: "2" } },
                    [
                      _c("b-button", { on: { click: _vm.addEvent } }, [
                        _vm._v(_vm._s(_vm.$t("ui.add_new")))
                      ])
                    ],
                    1
                  )
                ])
              ])
            ])
          ])
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-edc54c04", module.exports)
  }
}

/***/ }),

/***/ 272:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(273)
/* template */
var __vue_template__ = __webpack_require__(274)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/productions/Edit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-b55c9004", Component.options)
  } else {
    hotAPI.reload("data-v-b55c9004", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 273:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            production: {}
        };
    },
    mounted: function mounted() {
        var _this = this;

        axios.get('/api/productions/' + this.$route.params.slug).then(function (response) {
            _this.production = response.data.data;
        });
    }
});

/***/ }),

/***/ 274:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("production-form", { attrs: { production: _vm.production } })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-b55c9004", module.exports)
  }
}

/***/ }),

/***/ 275:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(276)
/* template */
var __vue_template__ = __webpack_require__(277)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/events/Details.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-e6369baa", Component.options)
  } else {
    hotAPI.reload("data-v-e6369baa", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 276:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            event: {}
        };
    },
    mounted: function mounted() {
        var _this = this;

        axios.get('/api/events/' + this.$route.params.uid).then(function (response) {
            _this.event = response.data.data;
        });
    }
});

/***/ }),

/***/ 277:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.event.uid
    ? _c(
        "div",
        [
          _c("crud-toolbar", {
            attrs: {
              "resource-name": "events",
              "resource-id": _vm.$route.params.uid,
              "delete-redirect": {
                name: "production.details",
                params: { slug: _vm.event.production.slug }
              }
            }
          }),
          _vm._v(" "),
          _c("h1", [_vm._v(_vm._s(_vm.event.title))]),
          _vm._v(" "),
          _c("p", [_vm._v(_vm._s(_vm.event.description))]),
          _vm._v(" "),
          _c("p", [_vm._v(_vm._s(_vm.event.times.start))])
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-e6369baa", module.exports)
  }
}

/***/ }),

/***/ 278:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(279)
/* template */
var __vue_template__ = __webpack_require__(280)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/events/Edit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7d17d21e", Component.options)
  } else {
    hotAPI.reload("data-v-7d17d21e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 279:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            event: {}
        };
    },
    mounted: function mounted() {
        var _this = this;

        axios.get('/api/events/' + this.$route.params.uid).then(function (response) {
            _this.event = response.data.data;
        });
    }
});

/***/ }),

/***/ 280:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("event-form", { attrs: { event: _vm.event } })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7d17d21e", module.exports)
  }
}

/***/ }),

/***/ 281:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(282)
/* template */
var __vue_template__ = __webpack_require__(283)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/profile/Settings.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-174b54a8", Component.options)
  } else {
    hotAPI.reload("data-v-174b54a8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 282:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ 283:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c(
      "div",
      { staticClass: "col-6 offset-3" },
      [
        _c("passport-clients"),
        _vm._v(" "),
        _c("passport-authorized-clients"),
        _vm._v(" "),
        _c("passport-personal-access-tokens")
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-174b54a8", module.exports)
  }
}

/***/ }),

/***/ 284:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(285)
/* template */
var __vue_template__ = __webpack_require__(286)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/organizations/List.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4e282ecc", Component.options)
  } else {
    hotAPI.reload("data-v-4e282ecc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 285:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            organizations: [],
            newOrganizationName: ''
        };
    },

    methods: {
        goToDetailsView: function goToDetailsView(slug) {
            this.$router.push({
                name: 'organization.details',
                params: { slug: slug }
            });
        },
        createOrganization: function createOrganization() {
            var self = this;
            axios.post('/api/organizations', { "name": this.newOrganizationName }).then(function (response) {
                self.$router.push({
                    name: 'organization.edit',
                    params: { slug: response.data.data.slug }
                });
            });
        },
        getResults: function getResults() {
            var _this = this;

            var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;

            axios.get('/api/organizations?onlyMine=1', { params: { page: page } }).then(function (response) {
                _this.organizations = response.data.data;
            });
        }
    },
    mounted: function mounted() {
        this.getResults();
    }
});

/***/ }),

/***/ 286:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("p", [
        _c("span", {
          domProps: { innerHTML: _vm._s(_vm.$t("organization.list_intro")) }
        })
      ]),
      _vm._v(" "),
      _c(
        "p",
        { staticClass: "text-right" },
        [
          _c(
            "b-btn",
            {
              directives: [
                {
                  name: "b-modal",
                  rawName: "v-b-modal.modal-new-organization",
                  modifiers: { "modal-new-organization": true }
                }
              ],
              staticClass: "btn btn-sm btn-outline-secondary mb-3"
            },
            [_vm._v(_vm._s(_vm.$t("organization.create_new")) + "\n        ")]
          )
        ],
        1
      ),
      _vm._v(" "),
      _vm.organizations.length
        ? _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-10 offset-1" },
              _vm._l(_vm.organizations, function(organization) {
                return _c(
                  "b-card",
                  {
                    key: organization.slug,
                    staticClass: "cursor-pointer",
                    attrs: { "img-top": "" },
                    on: {
                      click: function($event) {
                        _vm.goToDetailsView(organization.slug)
                      }
                    }
                  },
                  [
                    _c("p", { staticClass: "card-text" }, [
                      _vm._v(
                        "\n                    " +
                          _vm._s(organization.name) +
                          "\n                "
                      )
                    ])
                  ]
                )
              })
            )
          ])
        : _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-10 offset-1" }, [
              _c("div", { staticClass: "alert alert-secondary" }, [
                _c("p", [
                  _vm._v(_vm._s(_vm.$t("organization.you_dont_have_any")))
                ])
              ])
            ])
          ]),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            id: "modal-new-organization",
            title: _vm.$t("organization.create_new"),
            "ok-title": _vm.$t("ui.create"),
            "cancel-title": _vm.$t("ui.cancel")
          },
          on: { ok: _vm.createOrganization }
        },
        [
          _c(
            "b-form",
            {
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  return _vm.createOrganization($event)
                }
              }
            },
            [
              _c(
                "b-form-group",
                {
                  attrs: {
                    label: _vm.$t("organization.attr.name"),
                    "label-for": "title"
                  }
                },
                [
                  _c("b-form-input", {
                    attrs: { id: "title", type: "text", required: "" },
                    model: {
                      value: _vm.newOrganizationName,
                      callback: function($$v) {
                        _vm.newOrganizationName = $$v
                      },
                      expression: "newOrganizationName"
                    }
                  })
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4e282ecc", module.exports)
  }
}

/***/ }),

/***/ 287:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(288)
/* template */
var __vue_template__ = __webpack_require__(289)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/organizations/Details.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-87a74cf8", Component.options)
  } else {
    hotAPI.reload("data-v-87a74cf8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 288:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            organization: {}
        };
    },

    methods: {},
    mounted: function mounted() {
        var _this = this;

        axios.get('/api/organizations/' + this.$route.params.slug).then(function (response) {
            _this.organization = response.data.data;
        });
    }
});

/***/ }),

/***/ 289:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.organization.slug
    ? _c(
        "div",
        [
          _c("crud-toolbar", {
            attrs: {
              "resource-name": "organizations",
              "resource-id": _vm.$route.params.slug
            }
          }),
          _vm._v(" "),
          _c("h1", [_vm._v(_vm._s(_vm.organization.name))])
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-87a74cf8", module.exports)
  }
}

/***/ }),

/***/ 290:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(291)
/* template */
var __vue_template__ = __webpack_require__(292)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/views/organizations/Edit.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5d705638", Component.options)
  } else {
    hotAPI.reload("data-v-5d705638", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 291:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            organization: {},
            form: {}
        };
    },

    methods: {
        onSubmit: function onSubmit() {
            var self = this;

            axios.put('/api/organizations/' + this.$route.params.slug, this.form).then(function (response) {

                self.$router.push({
                    name: 'organization.details',
                    params: { slug: response.data.data.slug }
                });
            });
        }
    },
    mounted: function mounted() {
        var _this = this;

        axios.get('/api/organizations/' + this.$route.params.slug).then(function (response) {
            _this.organization = response.data.data;
            _this.form = {
                name: _this.organization.name
            };
        });
    }
});

/***/ }),

/***/ 292:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.form.name
    ? _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-10 offset-1" },
          [
            _c(
              "b-form",
              {
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    return _vm.onSubmit($event)
                  }
                }
              },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("organization.attr.name"),
                      "label-for": "name"
                    }
                  },
                  [
                    _c("b-form-input", {
                      attrs: { id: "name", type: "text", required: "" },
                      model: {
                        value: _vm.form.name,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "name", $$v)
                        },
                        expression: "form.name"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-button",
                  {
                    staticClass: "btn-block",
                    attrs: { type: "submit", variant: "primary" }
                  },
                  [_vm._v(_vm._s(_vm.$t("ui.edit")))]
                )
              ],
              1
            )
          ],
          1
        )
      ])
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5d705638", module.exports)
  }
}

/***/ }),

/***/ 293:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/bootstrap-vue/es/index.js'");

/***/ }),

/***/ 4:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue-loader/lib/component-normalizer.js'");

/***/ }),

/***/ 406:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/@fortawesome/vue-fontawesome/index.js'");

/***/ }),

/***/ 407:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/@fortawesome/free-solid-svg-icons/index.es.js'");

/***/ }),

/***/ 408:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/@fortawesome/free-regular-svg-icons/index.es.js'");

/***/ }),

/***/ 409:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(410)
/* template */
var __vue_template__ = __webpack_require__(411)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/productions/ProductionTableRow.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0eb94e45", Component.options)
  } else {
    hotAPI.reload("data-v-0eb94e45", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 410:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['production'],
    methods: {
        openProduction: function openProduction(slug) {
            this.$router.push({ name: 'production.details', params: { slug: slug } });
        }
    }

});

/***/ }),

/***/ 411:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "tr",
    {
      on: {
        click: function($event) {
          _vm.openProduction(_vm.production.slug)
        }
      }
    },
    [
      _c("td", [_vm._v(_vm._s(_vm.production.title))]),
      _vm._v(" "),
      _c("td", [_vm._v(_vm._s(_vm.production.events.length))])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0eb94e45", module.exports)
  }
}

/***/ }),

/***/ 412:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(413)
/* template */
var __vue_template__ = __webpack_require__(414)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/productions/Form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-f9139af8", Component.options)
  } else {
    hotAPI.reload("data-v-f9139af8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 413:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['production'],
    data: function data() {
        return {
            form: {}
        };
    },


    methods: {
        removeHeaderImg: function removeHeaderImg() {
            this.form.header_img = null;
        },
        uploadHeaderImg: function uploadHeaderImg(e) {
            var self = this;
            var formData = new FormData();
            formData.append('image', e.srcElement.files[0]);
            axios.post('/api/images', formData, {
                onUploadProgress: this.uploadProgress,
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                errorHandle: false }).then(function (response) {
                self.form.header_img = response.data.uid;

                self.production.images.header.url = response.data.url;
            }).catch(function (error) {

                for (var i = 0; i < error.response.data.errors.image.length; i++) {
                    self.$notify({
                        type: 'error',
                        group: 'app',
                        title: self.$t('ui.validation_error'),
                        text: error.response.data.errors.image[i]
                    });
                }
            });
        },
        uploadProgress: function uploadProgress(progressEvent) {
            var percentCompleted = Math.round(progressEvent.loaded * 100 / progressEvent.total);
            console.log(percentCompleted);
        },
        onSubmit: function onSubmit(evt) {
            var self = this;

            axios.put('/api/productions/' + this.$route.params.slug, this.form).then(function (response) {

                self.$router.push({
                    name: 'production.details',
                    params: { slug: response.data.data.slug }
                });
            });
        }
    },
    watch: {

        // When the component initializes, the production prop is not yet populated,
        // it will be fetched with async request. Wait for it to complete, then set initial form
        // state to those values
        production: function production(_production) {
            this.form = {
                title: _production.title,
                description: _production.description,
                excerpt: _production.excerpt,
                header_img: _production.images.header ? _production.images.header.uid : null
            };
        }
    }

});

/***/ }),

/***/ 414:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c(
      "div",
      { staticClass: "col-10 offset-1" },
      [
        _vm.production.slug
          ? _c(
              "b-form",
              {
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    return _vm.onSubmit($event)
                  }
                }
              },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("production.attr.title"),
                      "label-for": "title",
                      description: _vm.$t("production.attr.title_description")
                    }
                  },
                  [
                    _c("b-form-input", {
                      attrs: { id: "title", type: "text", required: "" },
                      model: {
                        value: _vm.form.title,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "title", $$v)
                        },
                        expression: "form.title"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("production.img.header"),
                      "label-for": "header-img",
                      description: _vm.$t("production.img.header_description")
                    }
                  },
                  [
                    _vm.production.images.header
                      ? _c(
                          "div",
                          {
                            staticClass: "overlay-container",
                            on: {
                              click: function($event) {
                                _vm.removeHeaderImg()
                              }
                            }
                          },
                          [
                            _c("img", {
                              staticClass: "img-fluid",
                              attrs: {
                                src: _vm.production.images.header.url,
                                alt: _vm.$t("production.img.header")
                              }
                            }),
                            _vm._v(" "),
                            _c("div", { staticClass: "img-overlay" }, [
                              _c("span", [
                                _c("i", {
                                  staticClass: "far fa-trash-alt fa-10x"
                                })
                              ])
                            ])
                          ]
                        )
                      : _c("b-form-file", {
                          attrs: {
                            accept: "image/jpeg, image/png, image/webp",
                            placeholder: _vm.$t("production.img.select_file")
                          },
                          on: { change: _vm.uploadHeaderImg }
                        })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("production.attr.excerpt"),
                      description: _vm.$t(
                        "production.attr.excerpt_description"
                      ),
                      "label-for": "excerpt"
                    }
                  },
                  [
                    _c("b-form-textarea", {
                      attrs: { id: "excerpt", type: "text", rows: "4" },
                      model: {
                        value: _vm.form.excerpt,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "excerpt", $$v)
                        },
                        expression: "form.excerpt"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("production.attr.description"),
                      description: _vm.$t(
                        "production.attr.description_description"
                      ),
                      "label-for": "description"
                    }
                  },
                  [
                    _c("b-form-textarea", {
                      attrs: {
                        id: "description",
                        type: "text",
                        rows: "10",
                        required: ""
                      },
                      model: {
                        value: _vm.form.description,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "description", $$v)
                        },
                        expression: "form.description"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-button",
                  {
                    staticClass: "btn-block",
                    attrs: { type: "submit", variant: "primary" }
                  },
                  [_vm._v(_vm._s(_vm.$t("ui.edit")))]
                )
              ],
              1
            )
          : _vm._e()
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-f9139af8", module.exports)
  }
}

/***/ }),

/***/ 415:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(416)
/* template */
var __vue_template__ = __webpack_require__(417)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/events/Form.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1badb05f", Component.options)
  } else {
    hotAPI.reload("data-v-1badb05f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 416:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function(moment) {//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: ['event'],
    data: function data() {
        return {
            form: {}
        };
    },


    methods: {
        onSubmit: function onSubmit(evt) {
            var self = this;
            axios.put('/api/events/' + this.$route.params.uid, this.form).then(function (response) {

                self.$router.push({
                    name: 'event.details',
                    params: { uid: self.$route.params.uid }
                });
            });
        }
    },
    watch: {

        // When the component initializes, the event prop is not yet populated,
        // it will be fetched with async request. Wait for it to complete, then set initial form
        // state to those values
        event: function event(_event) {

            this.form = {
                title: _event.title,
                description: _event.description,
                excerpt: _event.excerpt,
                times: { end: moment(_event.times.end), start: moment(_event.times.start) }
            };
        }
    }

});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 417:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c(
      "div",
      { staticClass: "col-8 offset-2" },
      [
        _c("h2"),
        _vm._v(" "),
        _vm.form.times
          ? _c(
              "b-form",
              {
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                    return _vm.onSubmit($event)
                  }
                }
              },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("event.attr.start_time"),
                      "label-for": "start_time",
                      description: _vm.$t("event.attr.start_time_description")
                    }
                  },
                  [
                    _c("date-picker", {
                      attrs: { required: "" },
                      model: {
                        value: _vm.form.times.start,
                        callback: function($$v) {
                          _vm.$set(_vm.form.times, "start", $$v)
                        },
                        expression: "form.times.start"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("event.attr.end_time"),
                      "label-for": "end_time",
                      description: _vm.$t("event.attr.end_time_description")
                    }
                  },
                  [
                    _c("date-picker", {
                      attrs: { required: "" },
                      model: {
                        value: _vm.form.times.end,
                        callback: function($$v) {
                          _vm.$set(_vm.form.times, "end", $$v)
                        },
                        expression: "form.times.end"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("event.attr.title"),
                      "label-for": "title",
                      description: _vm.$t("event.attr.title_description")
                    }
                  },
                  [
                    _c("b-form-input", {
                      attrs: { id: "title", type: "text" },
                      model: {
                        value: _vm.form.title,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "title", $$v)
                        },
                        expression: "form.title"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: _vm.$t("event.attr.description"),
                      description: _vm.$t("event.attr.description_description"),
                      "label-for": "description"
                    }
                  },
                  [
                    _c("b-form-textarea", {
                      attrs: {
                        id: "description",
                        type: "text",
                        rows: "10",
                        placeholder: _vm.$t(
                          "production.attr.description_placeholder"
                        )
                      },
                      model: {
                        value: _vm.form.description,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "description", $$v)
                        },
                        expression: "form.description"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-button",
                  {
                    staticClass: "btn-block",
                    attrs: { type: "submit", variant: "primary" }
                  },
                  [_vm._v(_vm._s(_vm.$t("ui.edit")))]
                )
              ],
              1
            )
          : _vm._e()
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1badb05f", module.exports)
  }
}

/***/ }),

/***/ 418:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/laravel-vue-pagination/dist/laravel-vue-pagination.common.js'");

/***/ }),

/***/ 419:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(420)
/* template */
var __vue_template__ = __webpack_require__(421)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/CrudToolbar.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-fa9c85fc", Component.options)
  } else {
    hotAPI.reload("data-v-fa9c85fc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 420:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: {
        resourceName: String,
        resourceId: String,
        deleteRedirect: {
            type: [String, Object],
            default: ''
        }
    },
    data: function data() {
        return {};
    },
    computed: {
        editLink: function editLink() {
            return '/' + this.resourceName + '/' + this.resourceId + '/edit';
        },
        deletePath: function deletePath() {
            return '/api/' + this.resourceName + '/' + this.resourceId;
        },
        deleteRedirectUri: function deleteRedirectUri() {
            return this.deleteRedirect !== '' ? this.deleteRedirect : { name: this.resourceName };
        }

    },
    methods: {
        markAsDeleted: function markAsDeleted() {
            var self = this;
            axios.delete(this.deletePath).then(function (response) {
                self.$router.push(self.deleteRedirectUri);
            });
        }
    }
});

/***/ }),

/***/ 421:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "b-button-toolbar",
    { attrs: { "key-nav": "" } },
    [
      _c(
        "b-button-group",
        { staticClass: "mx-1" },
        [
          _c(
            "router-link",
            {
              staticClass: "btn btn-sm btn-outline-secondary",
              attrs: { to: _vm.editLink }
            },
            [_vm._v(_vm._s(_vm.$t("ui.edit")) + "\n        ")]
          ),
          _vm._v(" "),
          _c(
            "b-button",
            {
              attrs: { size: "sm", variant: "outline-danger" },
              on: { click: _vm.markAsDeleted }
            },
            [_vm._v(_vm._s(_vm.$t("ui.delete")))]
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-fa9c85fc", module.exports)
  }
}

/***/ }),

/***/ 422:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(423)
}
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(426)
/* template */
var __vue_template__ = __webpack_require__(427)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4f7ebb76"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/passport/Clients.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4f7ebb76", Component.options)
  } else {
    hotAPI.reload("data-v-4f7ebb76", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 423:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(424);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(201)("936892f6", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4f7ebb76\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Clients.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4f7ebb76\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Clients.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 424:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(18)(false);
// imports


// module
exports.push([module.i, "\n.action-link[data-v-4f7ebb76] {\n    cursor: pointer;\n}\n", ""]);

// exports


/***/ }),

/***/ 426:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    /*
     * The component's data.
     */
    data: function data() {
        return {
            clients: [],

            createForm: {
                errors: [],
                name: '',
                redirect: ''
            },

            editForm: {
                errors: [],
                name: '',
                redirect: ''
            }
        };
    },


    /**
     * Prepare the component (Vue 1.x).
     */
    ready: function ready() {
        this.prepareComponent();
    },


    /**
     * Prepare the component (Vue 2.x).
     */
    mounted: function mounted() {
        this.prepareComponent();
    },


    methods: {
        /**
         * Prepare the component.
         */
        prepareComponent: function prepareComponent() {
            this.getClients();

            $('#modal-create-client').on('shown.bs.modal', function () {
                $('#create-client-name').focus();
            });

            $('#modal-edit-client').on('shown.bs.modal', function () {
                $('#edit-client-name').focus();
            });
        },


        /**
         * Get all of the OAuth clients for the user.
         */
        getClients: function getClients() {
            var _this = this;

            axios.get('/oauth/clients').then(function (response) {
                _this.clients = response.data;
            });
        },


        /**
         * Show the form for creating new clients.
         */
        showCreateClientForm: function showCreateClientForm() {
            $('#modal-create-client').modal('show');
        },


        /**
         * Create a new OAuth client for the user.
         */
        store: function store() {
            this.persistClient('post', '/oauth/clients', this.createForm, '#modal-create-client');
        },


        /**
         * Edit the given client.
         */
        edit: function edit(client) {
            this.editForm.id = client.id;
            this.editForm.name = client.name;
            this.editForm.redirect = client.redirect;

            $('#modal-edit-client').modal('show');
        },


        /**
         * Update the client being edited.
         */
        update: function update() {
            this.persistClient('put', '/oauth/clients/' + this.editForm.id, this.editForm, '#modal-edit-client');
        },


        /**
         * Persist the client to storage using the given form.
         */
        persistClient: function persistClient(method, uri, form, modal) {
            var _this2 = this;

            form.errors = [];

            axios[method](uri, form).then(function (response) {
                _this2.getClients();

                form.name = '';
                form.redirect = '';
                form.errors = [];

                $(modal).modal('hide');
            }).catch(function (error) {
                if (_typeof(error.response.data) === 'object') {
                    form.errors = _.flatten(_.toArray(error.response.data.errors));
                } else {
                    form.errors = ['Something went wrong. Please try again.'];
                }
            });
        },


        /**
         * Destroy the given client.
         */
        destroy: function destroy(client) {
            var _this3 = this;

            axios.delete('/oauth/clients/' + client.id).then(function (response) {
                _this3.getClients();
            });
        }
    }
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(11)))

/***/ }),

/***/ 427:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "card card-default" }, [
      _c("div", { staticClass: "card-header" }, [
        _c(
          "div",
          {
            staticStyle: {
              display: "flex",
              "justify-content": "space-between",
              "align-items": "center"
            }
          },
          [
            _c("span", [
              _vm._v("\n                    OAuth Clients\n                ")
            ]),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "action-link",
                attrs: { tabindex: "-1" },
                on: { click: _vm.showCreateClientForm }
              },
              [
                _vm._v(
                  "\n                    Create New Client\n                "
                )
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card-body" }, [
        _vm.clients.length === 0
          ? _c("p", { staticClass: "mb-0" }, [
              _vm._v(
                "\n                You have not created any OAuth clients.\n            "
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.clients.length > 0
          ? _c("table", { staticClass: "table table-borderless mb-0" }, [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.clients, function(client) {
                  return _c("tr", [
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _vm._v(
                        "\n                            " +
                          _vm._s(client.id) +
                          "\n                        "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _vm._v(
                        "\n                            " +
                          _vm._s(client.name) +
                          "\n                        "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _c("code", [_vm._v(_vm._s(client.secret))])
                    ]),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _c(
                        "a",
                        {
                          staticClass: "action-link",
                          attrs: { tabindex: "-1" },
                          on: {
                            click: function($event) {
                              _vm.edit(client)
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                                Edit\n                            "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _c(
                        "a",
                        {
                          staticClass: "action-link text-danger",
                          on: {
                            click: function($event) {
                              _vm.destroy(client)
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                                Delete\n                            "
                          )
                        ]
                      )
                    ])
                  ])
                })
              )
            ])
          : _vm._e()
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-create-client", tabindex: "-1", role: "dialog" }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content" }, [
            _vm._m(1),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _vm.createForm.errors.length > 0
                ? _c("div", { staticClass: "alert alert-danger" }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("br"),
                    _vm._v(" "),
                    _c(
                      "ul",
                      _vm._l(_vm.createForm.errors, function(error) {
                        return _c("li", [
                          _vm._v(
                            "\n                                " +
                              _vm._s(error) +
                              "\n                            "
                          )
                        ])
                      })
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("form", { attrs: { role: "form" } }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-md-3 col-form-label" }, [
                    _vm._v("Name")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-9" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.createForm.name,
                          expression: "createForm.name"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { id: "create-client-name", type: "text" },
                      domProps: { value: _vm.createForm.name },
                      on: {
                        keyup: function($event) {
                          if (
                            !("button" in $event) &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.store($event)
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.createForm, "name", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", { staticClass: "form-text text-muted" }, [
                      _vm._v(
                        "\n                                    Something your users will recognize and trust.\n                                "
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-md-3 col-form-label" }, [
                    _vm._v("Redirect URL")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-9" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.createForm.redirect,
                          expression: "createForm.redirect"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", name: "redirect" },
                      domProps: { value: _vm.createForm.redirect },
                      on: {
                        keyup: function($event) {
                          if (
                            !("button" in $event) &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.store($event)
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.createForm,
                            "redirect",
                            $event.target.value
                          )
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", { staticClass: "form-text text-muted" }, [
                      _vm._v(
                        "\n                                    Your application's authorization callback URL.\n                                "
                      )
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-secondary",
                  attrs: { type: "button", "data-dismiss": "modal" }
                },
                [_vm._v("Close")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button" },
                  on: { click: _vm.store }
                },
                [
                  _vm._v(
                    "\n                        Create\n                    "
                  )
                ]
              )
            ])
          ])
        ])
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-edit-client", tabindex: "-1", role: "dialog" }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content" }, [
            _vm._m(3),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _vm.editForm.errors.length > 0
                ? _c("div", { staticClass: "alert alert-danger" }, [
                    _vm._m(4),
                    _vm._v(" "),
                    _c("br"),
                    _vm._v(" "),
                    _c(
                      "ul",
                      _vm._l(_vm.editForm.errors, function(error) {
                        return _c("li", [
                          _vm._v(
                            "\n                                " +
                              _vm._s(error) +
                              "\n                            "
                          )
                        ])
                      })
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("form", { attrs: { role: "form" } }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-md-3 col-form-label" }, [
                    _vm._v("Name")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-9" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.editForm.name,
                          expression: "editForm.name"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { id: "edit-client-name", type: "text" },
                      domProps: { value: _vm.editForm.name },
                      on: {
                        keyup: function($event) {
                          if (
                            !("button" in $event) &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.update($event)
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.editForm, "name", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", { staticClass: "form-text text-muted" }, [
                      _vm._v(
                        "\n                                    Something your users will recognize and trust.\n                                "
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-md-3 col-form-label" }, [
                    _vm._v("Redirect URL")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-9" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.editForm.redirect,
                          expression: "editForm.redirect"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", name: "redirect" },
                      domProps: { value: _vm.editForm.redirect },
                      on: {
                        keyup: function($event) {
                          if (
                            !("button" in $event) &&
                            _vm._k(
                              $event.keyCode,
                              "enter",
                              13,
                              $event.key,
                              "Enter"
                            )
                          ) {
                            return null
                          }
                          return _vm.update($event)
                        },
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.editForm,
                            "redirect",
                            $event.target.value
                          )
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("span", { staticClass: "form-text text-muted" }, [
                      _vm._v(
                        "\n                                    Your application's authorization callback URL.\n                                "
                      )
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-secondary",
                  attrs: { type: "button", "data-dismiss": "modal" }
                },
                [_vm._v("Close")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button" },
                  on: { click: _vm.update }
                },
                [
                  _vm._v(
                    "\n                        Save Changes\n                    "
                  )
                ]
              )
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Client ID")]),
        _vm._v(" "),
        _c("th", [_vm._v("Name")]),
        _vm._v(" "),
        _c("th", [_vm._v("Secret")]),
        _vm._v(" "),
        _c("th"),
        _vm._v(" "),
        _c("th")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("\n                        Create Client\n                    ")
      ]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-hidden": "true"
          }
        },
        [_vm._v("×")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "mb-0" }, [
      _c("strong", [_vm._v("Whoops!")]),
      _vm._v(" Something went wrong!")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("\n                        Edit Client\n                    ")
      ]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-hidden": "true"
          }
        },
        [_vm._v("×")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "mb-0" }, [
      _c("strong", [_vm._v("Whoops!")]),
      _vm._v(" Something went wrong!")
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4f7ebb76", module.exports)
  }
}

/***/ }),

/***/ 428:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(429)
}
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(431)
/* template */
var __vue_template__ = __webpack_require__(432)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-76c5494a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/passport/AuthorizedClients.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-76c5494a", Component.options)
  } else {
    hotAPI.reload("data-v-76c5494a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 429:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(430);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(201)("9a53306e", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-76c5494a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./AuthorizedClients.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-76c5494a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./AuthorizedClients.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 430:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(18)(false);
// imports


// module
exports.push([module.i, "\n.action-link[data-v-76c5494a] {\n    cursor: pointer;\n}\n", ""]);

// exports


/***/ }),

/***/ 431:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    /*
     * The component's data.
     */
    data: function data() {
        return {
            tokens: []
        };
    },


    /**
     * Prepare the component (Vue 1.x).
     */
    ready: function ready() {
        this.prepareComponent();
    },


    /**
     * Prepare the component (Vue 2.x).
     */
    mounted: function mounted() {
        this.prepareComponent();
    },


    methods: {
        /**
         * Prepare the component (Vue 2.x).
         */
        prepareComponent: function prepareComponent() {
            this.getTokens();
        },


        /**
         * Get all of the authorized tokens for the user.
         */
        getTokens: function getTokens() {
            var _this = this;

            axios.get('/oauth/tokens').then(function (response) {
                _this.tokens = response.data;
            });
        },


        /**
         * Revoke the given token.
         */
        revoke: function revoke(token) {
            var _this2 = this;

            axios.delete('/oauth/tokens/' + token.id).then(function (response) {
                _this2.getTokens();
            });
        }
    }
});

/***/ }),

/***/ 432:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm.tokens.length > 0
      ? _c("div", [
          _c("div", { staticClass: "card card-default" }, [
            _c("div", { staticClass: "card-header" }, [
              _vm._v("Authorized Applications")
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "card-body" }, [
              _c("table", { staticClass: "table table-borderless mb-0" }, [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.tokens, function(token) {
                    return _c("tr", [
                      _c(
                        "td",
                        { staticStyle: { "vertical-align": "middle" } },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(token.client.name) +
                              "\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticStyle: { "vertical-align": "middle" } },
                        [
                          token.scopes.length > 0
                            ? _c("span", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(token.scopes.join(", ")) +
                                    "\n                                "
                                )
                              ])
                            : _vm._e()
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticStyle: { "vertical-align": "middle" } },
                        [
                          _c(
                            "a",
                            {
                              staticClass: "action-link text-danger",
                              on: {
                                click: function($event) {
                                  _vm.revoke(token)
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n                                    Revoke\n                                "
                              )
                            ]
                          )
                        ]
                      )
                    ])
                  })
                )
              ])
            ])
          ])
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Name")]),
        _vm._v(" "),
        _c("th", [_vm._v("Scopes")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-76c5494a", module.exports)
  }
}

/***/ }),

/***/ 433:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(434)
}
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(436)
/* template */
var __vue_template__ = __webpack_require__(437)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-e2692200"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/components/passport/PersonalAccessTokens.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-e2692200", Component.options)
  } else {
    hotAPI.reload("data-v-e2692200", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 434:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(435);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(201)("156e603e", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e2692200\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PersonalAccessTokens.vue", function() {
     var newContent = require("!!../../../../../node_modules/css-loader/index.js!../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-e2692200\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./PersonalAccessTokens.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 435:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(18)(false);
// imports


// module
exports.push([module.i, "\n.action-link[data-v-e2692200] {\n    cursor: pointer;\n}\n", ""]);

// exports


/***/ }),

/***/ 436:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    /*
     * The component's data.
     */
    data: function data() {
        return {
            accessToken: null,

            tokens: [],
            scopes: [],

            form: {
                name: '',
                scopes: [],
                errors: []
            }
        };
    },


    /**
     * Prepare the component (Vue 1.x).
     */
    ready: function ready() {
        this.prepareComponent();
    },


    /**
     * Prepare the component (Vue 2.x).
     */
    mounted: function mounted() {
        this.prepareComponent();
    },


    methods: {
        /**
         * Prepare the component.
         */
        prepareComponent: function prepareComponent() {
            this.getTokens();
            this.getScopes();

            $('#modal-create-token').on('shown.bs.modal', function () {
                $('#create-token-name').focus();
            });
        },


        /**
         * Get all of the personal access tokens for the user.
         */
        getTokens: function getTokens() {
            var _this = this;

            axios.get('/oauth/personal-access-tokens').then(function (response) {
                _this.tokens = response.data;
            });
        },


        /**
         * Get all of the available scopes.
         */
        getScopes: function getScopes() {
            var _this2 = this;

            axios.get('/oauth/scopes').then(function (response) {
                _this2.scopes = response.data;
            });
        },


        /**
         * Show the form for creating new tokens.
         */
        showCreateTokenForm: function showCreateTokenForm() {
            $('#modal-create-token').modal('show');
        },


        /**
         * Create a new personal access token.
         */
        store: function store() {
            var _this3 = this;

            this.accessToken = null;

            this.form.errors = [];

            axios.post('/oauth/personal-access-tokens', this.form).then(function (response) {
                _this3.form.name = '';
                _this3.form.scopes = [];
                _this3.form.errors = [];

                _this3.tokens.push(response.data.token);

                _this3.showAccessToken(response.data.accessToken);
            }).catch(function (error) {
                if (_typeof(error.response.data) === 'object') {
                    _this3.form.errors = _.flatten(_.toArray(error.response.data.errors));
                } else {
                    _this3.form.errors = ['Something went wrong. Please try again.'];
                }
            });
        },


        /**
         * Toggle the given scope in the list of assigned scopes.
         */
        toggleScope: function toggleScope(scope) {
            if (this.scopeIsAssigned(scope)) {
                this.form.scopes = _.reject(this.form.scopes, function (s) {
                    return s == scope;
                });
            } else {
                this.form.scopes.push(scope);
            }
        },


        /**
         * Determine if the given scope has been assigned to the token.
         */
        scopeIsAssigned: function scopeIsAssigned(scope) {
            return _.indexOf(this.form.scopes, scope) >= 0;
        },


        /**
         * Show the given access token to the user.
         */
        showAccessToken: function showAccessToken(accessToken) {
            $('#modal-create-token').modal('hide');

            this.accessToken = accessToken;

            $('#modal-access-token').modal('show');
        },


        /**
         * Revoke the given token.
         */
        revoke: function revoke(token) {
            var _this4 = this;

            axios.delete('/oauth/personal-access-tokens/' + token.id).then(function (response) {
                _this4.getTokens();
            });
        }
    }
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(11)))

/***/ }),

/***/ 437:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", [
      _c("div", { staticClass: "card card-default" }, [
        _c("div", { staticClass: "card-header" }, [
          _c(
            "div",
            {
              staticStyle: {
                display: "flex",
                "justify-content": "space-between",
                "align-items": "center"
              }
            },
            [
              _c("span", [
                _vm._v(
                  "\n                        Personal Access Tokens\n                    "
                )
              ]),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "action-link",
                  attrs: { tabindex: "-1" },
                  on: { click: _vm.showCreateTokenForm }
                },
                [
                  _vm._v(
                    "\n                        Create New Token\n                    "
                  )
                ]
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "card-body" }, [
          _vm.tokens.length === 0
            ? _c("p", { staticClass: "mb-0" }, [
                _vm._v(
                  "\n                    You have not created any personal access tokens.\n                "
                )
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.tokens.length > 0
            ? _c("table", { staticClass: "table table-borderless mb-0" }, [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "tbody",
                  _vm._l(_vm.tokens, function(token) {
                    return _c("tr", [
                      _c(
                        "td",
                        { staticStyle: { "vertical-align": "middle" } },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(token.name) +
                              "\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        { staticStyle: { "vertical-align": "middle" } },
                        [
                          _c(
                            "a",
                            {
                              staticClass: "action-link text-danger",
                              on: {
                                click: function($event) {
                                  _vm.revoke(token)
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n                                    Delete\n                                "
                              )
                            ]
                          )
                        ]
                      )
                    ])
                  })
                )
              ])
            : _vm._e()
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-create-token", tabindex: "-1", role: "dialog" }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content" }, [
            _vm._m(1),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _vm.form.errors.length > 0
                ? _c("div", { staticClass: "alert alert-danger" }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("br"),
                    _vm._v(" "),
                    _c(
                      "ul",
                      _vm._l(_vm.form.errors, function(error) {
                        return _c("li", [
                          _vm._v(
                            "\n                                " +
                              _vm._s(error) +
                              "\n                            "
                          )
                        ])
                      })
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c(
                "form",
                {
                  attrs: { role: "form" },
                  on: {
                    submit: function($event) {
                      $event.preventDefault()
                      return _vm.store($event)
                    }
                  }
                },
                [
                  _c("div", { staticClass: "form-group row" }, [
                    _c("label", { staticClass: "col-md-4 col-form-label" }, [
                      _vm._v("Name")
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-md-6" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.form.name,
                            expression: "form.name"
                          }
                        ],
                        staticClass: "form-control",
                        attrs: {
                          id: "create-token-name",
                          type: "text",
                          name: "name"
                        },
                        domProps: { value: _vm.form.name },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.form, "name", $event.target.value)
                          }
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.scopes.length > 0
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          { staticClass: "col-md-4 col-form-label" },
                          [_vm._v("Scopes")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-6" },
                          _vm._l(_vm.scopes, function(scope) {
                            return _c("div", [
                              _c("div", { staticClass: "checkbox" }, [
                                _c("label", [
                                  _c("input", {
                                    attrs: { type: "checkbox" },
                                    domProps: {
                                      checked: _vm.scopeIsAssigned(scope.id)
                                    },
                                    on: {
                                      click: function($event) {
                                        _vm.toggleScope(scope.id)
                                      }
                                    }
                                  }),
                                  _vm._v(
                                    "\n\n                                                " +
                                      _vm._s(scope.id) +
                                      "\n                                        "
                                  )
                                ])
                              ])
                            ])
                          })
                        )
                      ])
                    : _vm._e()
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-secondary",
                  attrs: { type: "button", "data-dismiss": "modal" }
                },
                [_vm._v("Close")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button" },
                  on: { click: _vm.store }
                },
                [
                  _vm._v(
                    "\n                        Create\n                    "
                  )
                ]
              )
            ])
          ])
        ])
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-access-token", tabindex: "-1", role: "dialog" }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content" }, [
            _vm._m(3),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _c("p", [
                _vm._v(
                  "\n                        Here is your new personal access token. This is the only time it will be shown so don't lose it!\n                        You may now use this token to make API requests.\n                    "
                )
              ]),
              _vm._v(" "),
              _c(
                "textarea",
                { staticClass: "form-control", attrs: { rows: "10" } },
                [_vm._v(_vm._s(_vm.accessToken))]
              )
            ]),
            _vm._v(" "),
            _vm._m(4)
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [_c("th", [_vm._v("Name")]), _vm._v(" "), _c("th")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("\n                        Create Token\n                    ")
      ]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-hidden": "true"
          }
        },
        [_vm._v("×")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "mb-0" }, [
      _c("strong", [_vm._v("Whoops!")]),
      _vm._v(" Something went wrong!")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v(
          "\n                        Personal Access Token\n                    "
        )
      ]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-hidden": "true"
          }
        },
        [_vm._v("×")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-secondary",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("Close")]
      )
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-e2692200", module.exports)
  }
}

/***/ }),

/***/ 438:
/***/ (function(module, exports) {

module.exports = {"et":{"nav":{"productions":"Produktsioonid","home":"Avaleht","organizations":"Organisatsioonid"},"dash":{"greeting":"Meie homne on meie endi teha. - Ilves"},"event":{"attr":{"title":"Pealkiri","title_description":"Etenduse alampealkiri, kui see erineb produktsiooni pealkirjast (külastajale näidatakse mõlemat pealkirja). Jäta väli tühjaks, kui alampealkirja pole vaja.","description":"Kirjeldus","description_description":"Etenduse kirjeldus, kui on vaja midagi konkreetse [rituse kohta täpsustada. V]ib jätta tühjaks.","start_time":"Algus","start_time_description":"Ürituse alguskuupäev- ja kella-aeg","end_time":"Lõpp","end_time_description":"Ürituse alguskuupäev- ja kella-aeg"}},"organization":{"list_intro":"Organisatsioonid on produktsioone korraldavad trupid.","create_new":"Uus organisatsioon","you_dont_have_any":"Sind pole veel ühtegi organisatsiooni lisatud","attr":{"name":"Nimi"}},"production":{"no_events":"Ühtegi sündmust pole lisatud","num_of_events":"Etendusi","list_intro":"See tabel näitab kõiki produktsioone, mida sinu organisatsioonid loonud on. <i>Produktsioon</i> on suurem etenduse kontseptsioon ja -formaat. Ühel produktsioonil on tüüpiliselt mitu erinevat <i>etenduse</i> aega.","create_new":"Uus produktsioon","attr":{"title":"Pealkiri","title_description":"Formaadi, lavastuse või festivali nimetus","excerpt":"Lühikirjeldus","excerpt_description":"Lühikokkuvõtet kuvatakse mängukava koondvaates, kuhu iga etenduse täispikk kirjeldus ei mahu.","description":"Kirjeldus","description_description":"Millega tegu on? Kuidas formaat välja näeb? See on produktsiooni \"müügikõne\"."},"img":{"header":"Päise pilt","header_description":"Pilti kuvatakse etenduse lehe päises. Peaks olema laiformaadis (16:9) ja vähemalt 600px kõrge.","select_file":"Vali fail..."}}}}

/***/ }),

/***/ 439:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(4)
/* script */
var __vue_script__ = __webpack_require__(440)
/* template */
var __vue_template__ = __webpack_require__(441)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/admin/App.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-65bd4233", Component.options)
  } else {
    hotAPI.reload("data-v-65bd4233", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 440:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ 441:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-8 offset-2" },
        [
          _c("notifications", {
            attrs: { group: "app", position: "top center" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-2" }, [
        _c(
          "nav",
          { staticClass: "nav flex-column" },
          [
            _c(
              "router-link",
              {
                staticClass:
                  "flex-sm-fill nav-link text-sm-center p-2 text-muted",
                attrs: { exact: "", "active-class": "active", to: "/" }
              },
              [_vm._v(_vm._s(_vm.$t("nav.home")) + "\n                ")]
            ),
            _vm._v(" "),
            _c(
              "router-link",
              {
                staticClass:
                  "flex-sm-fill nav-link text-sm-center p-2 text-muted",
                attrs: { "active-class": "active", to: { name: "productions" } }
              },
              [_vm._v(_vm._s(_vm.$t("nav.productions")) + "\n                ")]
            ),
            _vm._v(" "),
            _c(
              "router-link",
              {
                staticClass:
                  "flex-sm-fill nav-link text-sm-center p-2 text-muted",
                attrs: {
                  "active-class": "active",
                  to: { name: "organizations" }
                }
              },
              [
                _vm._v(
                  _vm._s(_vm.$t("nav.organizations")) + "\n                "
                )
              ]
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-10" }, [_c("router-view")], 1)
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-65bd4233", module.exports)
  }
}

/***/ }),

/***/ 458:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/@sentry/browser/dist/index.js'");

/***/ }),

/***/ 9:
/***/ (function(module, exports) {

throw new Error("Module build failed: Error: ENOENT: no such file or directory, open '/home/ando/src/improv/improv-v2/src/node_modules/vue/dist/vue.common.js'");

/***/ })

/******/ });