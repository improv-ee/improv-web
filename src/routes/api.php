<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('productions', 'Api\ProductionController', ['as'=>'api'])->only([
    'index', 'show'
]);

Route::get('/events/schedule','Api\EventController@schedule',['as'=>'api'])->name('api.events.schedule');

Route::resource('events', 'Api\EventController', ['as'=>'api'])->only([
    'index', 'show'
]);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('productions', 'Api\ProductionController')->only(['store','destroy','update']);
    Route::apiResource('events', 'Api\EventController')->only(['store','destroy','update']);
});

