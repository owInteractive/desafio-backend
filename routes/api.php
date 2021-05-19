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

Route::post('login','Auth\AuthController@login');

Route::group(['middleware' => ['jwt.auth']], function(){
    Route::namespace('Api')->group(function (){

        Route::get('user','UserController@index');
        Route::get('user/{id}','UserController@show');
        Route::post('user','UserController@store');
        Route::delete('user/{id}','UserController@destroy');
        Route::put('updateUserBalance/{id}','UserController@updateBalance');
        Route::get('sumUserTransactionsAndBalance/{id}','UserController@sumUserTransactionsAndBalance');

        Route::get('transaction','TransactionController@index');
        Route::get('transaction/{id}','TransactionController@show');
        Route::post('transaction','TransactionController@store');
        Route::delete('transaction','TransactionController@destroy');

        Route::get('exportTransaction','TransactionController@export');
        //Route::resource('transaction','TransactionController');


    });
});
