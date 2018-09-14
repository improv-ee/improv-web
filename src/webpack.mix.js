const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/public/app.js', 'public/js')
    .sass('resources/sass/public/app.scss', 'public/css');

mix.js('resources/js/admin/app.js','public/js/admin')
    .autoload({
        'jquery': ['$', 'window.jQuery', 'jQuery'],
        'vue': ['Vue','window.Vue'],
        'moment': ['moment','window.moment'],
    })
    .sass('resources/sass/admin/admin.scss', 'public/css');