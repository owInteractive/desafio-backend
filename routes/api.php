<?php

declare(strict_types=1);

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
Route::prefix('auth')->as('auth:')->group(function () {
    Route::post('/signin', App\Http\Controllers\Api\Auth\SignInController::class)->name('signin');
    Route::post('/login', App\Http\Controllers\Api\Auth\LoginController::class)->name('login');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->as('users:')->group(function () {
        Route::get('/', App\Http\Controllers\Api\Users\IndexController::class)->name('index');
        Route::get('/{id}', App\Http\Controllers\Api\Users\ShowController::class)->name('show');
        Route::delete('/{id}', App\Http\Controllers\Api\Users\DeleteController::class)->name('delete');
        Route::put('/{id}/change-balance', App\Http\Controllers\Api\Users\ChangeBalanceController::class)->name('change-balance');
        Route::get('/{id}/balance', App\Http\Controllers\Api\Users\BalanceController::class)->name('balance');
    });

    Route::prefix('movements')->as('movements:')->group(function () {
        Route::get('/user/{id}', App\Http\Controllers\Api\Movements\IndexController::class)->name('index');
        Route::post('/', App\Http\Controllers\Api\Movements\StoreController::class)->name('store');
        Route::delete('/{id}/user/{userId}', App\Http\Controllers\Api\Movements\DeleteController::class)->name('delete');
        Route::post('/export/user/{id}', App\Http\Controllers\Api\Movements\ExportCsvController::class)->name('export-csv');
    });
});
