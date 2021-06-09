<?php

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\MovimentController;
use App\Http\Controllers\Client\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('/register', [RegisterController::class, 'handle']);

Route::group(['prefix' => '/', 'middleware' => ['auth:api', 'is:client']], function () {
    Route::post('change-opening-balance', [MovimentController::class, 'changeOpeningBalance']);
    Route::get('balance', [MovimentController::class, 'balance']);
    Route::apiResource('moviments', MovimentController::class)->except(['show', 'update']);

    Route::group(['prefix' => 'reports'], function () {
        Route::get('moviments', [MovimentController::class, 'report']);
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'is:admin']], function () {
    Route::apiResource('users', UserAdminController::class)->except(['update']);
});
