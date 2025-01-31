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


JsonApi::register('default')->routes(function ($api) {
    $api->resource('driver_vehicles')->relationships(function ($relations) {

    });
/*     $api->resource('ping')->relationships(function ($relations) {

    });*/

    $api->resource('order_status')->relationships(function ($relations) {

    });
    $api->resource('distances')->relationships(function ($relations) {

    });
    $api->resource('vehicle_types')->relationships(function ($relations) {

    });
    $api->resource('merchant_types')->relationships(function ($relations) {

    });
    $api->resource('vehicle_preferences')->relationships(function ($relations) {

    });
    $api->resource('settings')->relationships(function ($relations) {

    });

    $api->resource('paktec-own-items')->relationships(function ($relations) {

    });
    $api->resource('paktec-competitors-items')->relationships(function ($relations) {

    });



});




JsonApi::register('default')->routes(function ($api, $router) {
    $api->resource('ping'); //->controller('PingController');
});






/*
JsonApi::register('default')->routes(function ($api) {
    $api->get('/ping', 'Ping@checkin');

});*/
