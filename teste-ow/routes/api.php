<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TransitionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum'); 
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/download/transitions', [TransitionsController::class, 'download']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('transitions', TransitionsController::class)->except('update');
    Route::get('transitions/user/sum', [TransitionsController::class, 'sumTransitions'])->name('transitions.sum');
});