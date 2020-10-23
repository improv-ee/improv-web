<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/robots.txt', function () {
    return response()->view('robots')->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    return response(Storage::disk('media')->get('sitemap.xml'))
        ->header('Content-Type', 'application/xml');
});

Route::get('/maintenance', 'HomeController@maintenance')
    ->middleware('cache.headers:private;max_age=604800;etag')
    ->name('maintenance');

Auth::routes(['verify' => true]);


Route::namespace('Admin')
    ->prefix('admin')
    ->middleware(['auth', 'verified', 'cache.headers:private;max_age=604800;etag'])
    ->group(function () {
        Route::get('/{wildcard}', 'HomeController@index')->where('wildcard', '.*');
        Route::get('/', 'HomeController@index')->name('home');
    });

Route::group([
    'middleware' => ['web', 'language'],
    'as' => 'language::',
    'prefix' => config('language.prefix'),
], function () {
    Route::get('/{locale}', 'HomeController@locale')->name('locale');
});

Route::get('/not-found', function () {
    abort(404);
});

// Catch all route
// Matches the literal home page (/) as well as anything else (/yelp)
// Use-case: enable vue-router catch-all routing via history.pushstate
// https://router.vuejs.org/guide/essentials/history-mode.html#example-server-configurations
// Some special routes map to dedicated controllers; those are used for prerendering, for SEO meta tags
Route::group(['middleware' => ['cache.headers:private;max_age=86400;etag']], function () {
    Route::get('/events/{event}', 'EventController@show');
    Route::get('/organizations/{organization}', 'OrganizationController@show');

    Route::get('{wildcard}', 'HomeController@index')->where('wildcard', '.*');
});
