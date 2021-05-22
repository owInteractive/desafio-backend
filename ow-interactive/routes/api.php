<?php

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Client\RegisterController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [RegisterController::class, 'handle']);

Route::group(['prefix' => 'admin'], function () {
    Route::get('users', [UserAdminController::class, 'index']);
    Route::get('users/{id}', [UserAdminController::class, 'show']);
    Route::delete('users/{id}', [UserAdminController::class, 'destroy']);
});
