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

Route::get('/', function () {

    return view('frontpage');
});

Auth::routes(['verify' => true]);


Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});