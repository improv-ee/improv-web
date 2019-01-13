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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('productions', 'Api\ProductionController', ['as' => 'api'])->only([
    'index', 'show'
]);

Route::get('/', function(){return response(200,["title"=>"improvision.eu API","doc"=>"https://docs.improvision.eu"]);});

Route::get('/events/schedule', 'Api\EventController@schedule', ['as' => 'api'])->name('api.events.schedule');

Route::resource('events', 'Api\EventController', ['as' => 'api'])->only([
    'index', 'show'
]);

Route::resource('organizations', 'Api\OrganizationController', ['as' => 'api'])->only([
    'index', 'show'
]);
Route::resource('users','Api\UserController',['as'=>'api'])->only(['show']);

Route::apiResource('images', 'Api\ImageController', ['as' => 'api'])->only(['show']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('productions', 'Api\ProductionController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('organizations', 'Api\OrganizationController', ['as' => 'api'])->only(['store', 'destroy', 'update']);

    Route::apiResource('events', 'Api\EventController', ['as' => 'api'])->only(['store', 'destroy', 'update']);
    Route::apiResource('images', 'Api\ImageController', ['as' => 'api'])->only(['store']);


    Route::apiResource('organizations.membership', 'Api\Organization\MembershipController', ['as'=>'api', 'parameters'=>['membership'=>'user'] ])->only(['show','store', 'destroy', 'update']);
});

