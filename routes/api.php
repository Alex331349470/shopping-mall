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

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {

    Route::middleware('throttle:'.config('api.rate_limits.sign'))
        ->group(function (){
            Route::post('authorizations','AuthorizationsController@store')
                ->name('authorizations.store');
        });

    Route::middleware('throttle:'.config('api.rate_limits.access'))
        ->group(function (){
            Route::middleware('auth:api')->group(function (){
                Route::get('user', 'AuthorizationsController@me')
                    ->name('user.me');
            });
        });
});
