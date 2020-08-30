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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Authentication*/
Route::prefix('auth')->group(function(){
	Route::post("register", "AuthenticationController@register"); // cadastro do usuario
	Route::post("login", "AuthenticationController@login");

	Route::middleware('auth:api')->group(function(){
		Route::post("logout", "AuthenticationController@logout");
	});
});

Route::middleware('auth:api')->group(function(){
	/*Users*/
	Route::prefix('users')->group(function(){
		Route::get("", "UsersController@index");
		Route::get("{user}", "UsersController@show");
		Route::delete("{user}", "UsersController@eliminate");
		Route::patch("{user}", "UsersController@updateBalance");
	});

	/*Operations*/
	Route::prefix('operations')->group(function(){ 
		Route::get("", "OperationsController@index");
		Route::get("{operation}", "OperationsController@show");
		Route::get("user/{user}", "OperationsController@showUser");
		Route::get("status/{status}", "OperationsController@showStatus");
		Route::get("transaction/{transaction}", "OperationsController@showTransaction");
		Route::delete("{operation}/{user}", "OperationsController@eliminate");
		Route::get("amount/{user}", "OperationsController@amountUser");
	});

	/* Report via POST */
	Route::prefix('report')->group(function(){ 
		Route::post("", "OperationsController@reportPost");
	});
});

/* Reports via GET*/
Route::get("{param}", "OperationsController@reportGet");
Route::get("{param}/{user}", "OperationsController@reportGet");

Route::any('', function () {
    return response()->json(['message' => 'Rota nāo localizada'], 401);
});

Route::fallback(function () {
    return response()->json(['message' => 'Rota nāo localizada'], 401);
});



