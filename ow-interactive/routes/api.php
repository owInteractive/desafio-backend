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

Route::namespace('API')->group(function () {
    Route::post('/users/register', 'UserController@store');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix'=> 'users'], function()
        {
            Route::get('/', 'UserController@index');
            Route::get('/{id}', 'UserController@show');
            Route::delete('/destroy/{id}', 'UserController@destroy');
        });
    });
});

