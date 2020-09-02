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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/users', 'API\UserController@store');
Route::get('/users', 'API\UserController@index')->middleware('auth:api');
Route::get('/users/{user}', 'API\UserController@show')->middleware('auth:api');
Route::delete('/users/{user}', 'API\UserController@destroy')->middleware('auth:api');
Route::patch('/users/{user}/amount_initial', 'API\UserController@amountInitial');
Route::post('/users/{user}/balance', 'API\UserController@balance');

Route::post('/transactions', 'API\TransactionController@store')->middleware('auth:api');
Route::get('/transactions', 'API\TransactionController@index')->middleware('auth:api');
Route::delete('/transactions/{transaction}', 'API\TransactionController@destroy')->middleware('auth:api');
Route::post('/transactions/export', 'API\TransactionController@export')->middleware('auth:api');

