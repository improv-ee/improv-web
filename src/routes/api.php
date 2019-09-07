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

Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {

    Route::resource('productions', 'ProductionController', ['as' => 'api'])->only([
        'index', 'show'
    ]);

    Route::get('/events/schedule', 'EventController@schedule', ['as' => 'api'])
        ->name('api.events.schedule');

    Route::resource('events', 'EventController', ['as' => 'api'])
        ->only([
            'index', 'show'
        ]);

    Route::resource('organizations', 'OrganizationController', ['as' => 'api'])
        ->only([
            'index', 'show'
        ]);

    Route::resource('tags', 'TagController', ['as' => 'api'])
        ->only([
            'index'
        ]);

    Route::resource('users', 'UserController', ['as' => 'api'])
        ->only(['show']);

    Route::apiResource('images', 'ImageController', ['as' => 'api'])
        ->only(['show']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('productions', 'ProductionController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('organizations', 'OrganizationController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('events', 'EventController', ['as' => 'api'])->only(['store', 'destroy', 'update']);
    Route::apiResource('images', 'ImageController', ['as' => 'api'])->only(['store']);

    Route::get('/places/search', 'PlaceController@search', ['as' => 'api'])->name('api.places.search');

    Route::apiResource('organizations.membership', 'Organization\MembershipController', ['as' => 'api', 'parameters' => ['membership' => 'user']])->only(['show', 'store', 'destroy', 'update']);
});
