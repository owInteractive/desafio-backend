<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\MovementController;
use App\Http\Controllers\Api\FiltersController;
use App\Http\Controllers\Api\BalanceController;

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

    Route::group(['prefix'=>'movements','as'=>'movements.'], function(){
        Route::get('/', [MovementController::class,'index_all'])->name('movements.index_all');
        Route::get('{user_id}', [MovementController::class,'index'])->name('movements.index');
        Route::post('/', [MovementController::class,'store'])->name('movements.store');
        Route::delete('{id}', [MovementController::class,'destroy'])->name('movements.destroy');
    });
    
    Route::post('filters', [FiltersController::class,'export'])->name('movements.store');
    
    Route::group(['prefix'=>'balance','as'=>'balance.'], function(){
        Route::get('/{user_id}', [BalanceController::class,'index'])->name('balance.index');
        Route::put('/', [BalanceController::class,'update'])->name('balance.update'); 
    });
    
});