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

Route::group(['middleware' => ['json.response']], function () {

    Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {

        Route::middleware('auth:api')->group(function () {

            Route::resource('/households', 'HouseholdController');
            Route::resource('/household-members', 'MembersController');
            Route::resource('/children', 'ChildController');
            Route::resource('/sponsorship', 'SponsorshipController');
            Route::get('/stats', 'StatsController@index');

            Route::post('logout', 'AuthController@logout');

        });

        Route::post('register', 'AuthController@register');
        Route::get('get-random-children', 'ChildController@getFirstFive');
        Route::post('login', 'AuthController@login');

    });

});
