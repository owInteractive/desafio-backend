<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportCsvController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'getAll']);
        Route::get('movement', [UserController::class, 'getMovement']);
        Route::get('balance-total', [UserController::class, 'balanceTotal']);
        Route::get('/{id}', [UserController::class, 'getById']);
        Route::post('', [UserController::class, 'create']);
        Route::delete('/{id}', [UserController::class, 'delete']);
        Route::put('update-balance', [UserController::class, 'updateBalance']);
    });

    Route::prefix('movement')->group(function () {
        Route::post('credit', [MovementController::class, 'credit']);
        Route::post('debit', [MovementController::class, 'debit']);
        Route::post('reversal/{id}', [MovementController::class, 'reversal']);
        Route::delete('delete/{id}', [MovementController::class, 'delete']);

        Route::get('export-30-days', [ExportCsvController::class, 'exportLast30Days']);
        Route::get('export-date/{date}', [ExportCsvController::class, 'exportByDate']);
        Route::get('export', [ExportCsvController::class, 'exportAll']);
    });
});
