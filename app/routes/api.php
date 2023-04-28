<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/list', [UsersController::class, 'list'])->name('user.list');
        Route::post('/store', [UsersController::class, 'store'])->name('user.store');
        Route::get('/show/{id}', [UsersController::class, 'show'])->name('user.show');
        Route::delete('/destroy/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
        Route::put('/save-opening-balance/{id}', [UsersController::class, 'saveOpeningBalance'])->name('user.saveOpeningBalance');
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/get-transactions/{userId}/{paginate}', [TransactionsController::class, 'getTransactionsByUser']);
        Route::post('/store', [TransactionsController::class, 'store']);
        Route::delete('/destroy/{id}', [TransactionsController::class, 'destroy']);
        Route::post('/export/{userId}', [TransactionsController::class, 'export']);
    });
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
