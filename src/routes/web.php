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

Route::get('/', 'HomeController@index')
    ->middleware('cache.headers:private;max_age=604800;etag');

Route::get('/maintenance', 'HomeController@maintenance')
    ->middleware('cache.headers:private;max_age=604800;etag')
    ->name('maintenance');

Auth::routes(['verify' => true]);


Route::namespace('Admin')
    ->prefix('admin')
    ->middleware(['auth', 'verified', 'cache.headers:private;max_age=604800;etag'])
    ->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::group([
    'middleware' => ['web', 'language'],
    'as'         => 'language::',
    'prefix'     => config('language.prefix'),
], function () {
    Route::get('/{locale}',  'HomeController@locale')->name('locale');
});

// Special case - Estonian Improv 10 years celebration redirect
// TODO - remove after 2019
Route::get('/impro10', function(){
    return redirect('/#/productions/APQZj6KV5Zq5BJCD');
});
