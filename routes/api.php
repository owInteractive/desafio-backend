<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| The middleware is needed to accept json posts on request
|
*/

Route::group(['middleware' => ['json.response'], 'prefix' => 'v1'], function () {

    Route::resource('users', UsersController::class);

});