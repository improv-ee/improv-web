const mix = require('laravel-mix');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const webpack = require('webpack');

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

mix.js('resources/js/public/app.js', 'public/js').version();
mix.sass('resources/sass/public/app.scss', 'public/css').version();

mix.js('resources/js/admin/app.js', 'public/js/admin')
    .autoload({
      'jquery': ['$', 'window.jQuery', 'jQuery'],
      'vue': ['Vue', 'window.Vue'],
      'moment': ['moment', 'window.moment'],
    }).version();
mix.sass('resources/sass/admin/admin.scss', 'public/css').version();

mix.webpackConfig({
  module: {
    rules: [
      {
        enforce: 'pre',
        exclude: /node_modules/,
        loader: 'eslint-loader',
        test: /\.(js|vue)?$/
      },
    ]
  },
  plugins: [
    new BundleAnalyzerPlugin({
      openAnalyzer: false,
      analyzerMode: 'disabled',
      generateStatsFile: false,
      statsOptions: {source: false}
    }),
    new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
  ],
});