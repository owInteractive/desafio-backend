<?php

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Client\MovimentController;
use App\Http\Controllers\Client\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [RegisterController::class, 'handle']);
Route::post('change-opening-balance', [MovimentController::class, 'changeOpeningBalance']);
Route::apiResource('moviments', MovimentController::class)->except(['show', 'update']);

Route::group(['prefix' => 'reports'], function () {
    Route::get('moviments', [MovimentController::class, 'report']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::apiResource('users', UserAdminController::class)->except(['store', 'update']);
});
