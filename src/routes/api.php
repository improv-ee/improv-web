<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/search', 'UserController@search');
    Route::post('/user/invite', 'UserController@invite');
});


Route::middleware('cache.headers:etag')->as('api.')->group(function () {

    Route::apiResource('productions', 'ProductionController')->only(['index', 'show']);
    Route::get('/events/schedule', 'EventController@schedule')
        ->name('api.events.schedule');

    Route::apiResource('events', 'EventController')
        ->only(['show', 'index']);

    Route::apiResource('organizations', 'OrganizationController')
        ->only(['show', 'index']);

    Route::apiResource('tags', 'TagController')
        ->only(['index']);

    Route::apiResource('users', 'UserController')
        ->only(['show']);

    Route::apiResource('gigcategories', 'GigCategoryController')->only(['index']);

    Route::apiResource('gigads', 'GigadController')->only(['index', 'show']);

    Route::get('/images/{filename}/{conversion?}/{responsive?}', 'ImageController@show')->name('images.show')
        ->middleware('cache.headers:public;max_age=86400;etag');

});


Route::middleware('auth:api')->group(function () {

    Route::get('/heartbeat', function () {
        return ['status' => 'ok'];
    });

    Route::apiResource('productions', 'ProductionController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('gigads', 'GigadController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('organizations', 'OrganizationController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('events', 'EventController', ['as' => 'api'])->only(['store', 'destroy', 'update']);
    Route::apiResource('images', 'ImageController', ['as' => 'api'])->only(['store']);

    Route::get('/places/search', 'PlaceController@search', ['as' => 'api'])->name('api.places.search');

    Route::apiResource('organizations.membership', 'Organization\MembershipController', ['as' => 'api', 'parameters' => ['membership' => 'user']])->only(['show', 'store', 'destroy', 'update']);
});
