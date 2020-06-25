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
    $api->resource('pings')->relationships(function ($relations) {

    });

    $api->resource('order_status')->relationships(function ($relations) {

    });

    $api->resource('settings')->relationships(function ($relations) {

    });
});
