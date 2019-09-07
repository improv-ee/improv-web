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
    ->middleware('cache.headers:public;max_age=2628000;etag');
Route::get('/getConfig', 'HomeController@getConfig')->name('config');
Route::get('/maintenance', 'HomeController@maintenance')
    ->middleware('cache.headers:public;max_age=2628000;etag')
    ->name('maintenance');

Auth::routes(['verify' => true]);


Route::namespace('Admin')
    ->prefix('admin')
    ->middleware(['auth', 'verified', 'cache.headers:private;max_age=2628000;etag'])
    ->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});