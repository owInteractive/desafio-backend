<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\MovementController;
use App\Http\Controllers\Api\FiltersController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UsersController as UsersAuthController;
use App\Http\Controllers\Auth\BalanceController as BalanceAuthController;
use App\Http\Controllers\Auth\MovementsController as MovementsAuthController;

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

    /* PUBLIC ROUTES */
    Route::resource('users', UsersController::class);

    Route::group(['prefix'=>'movements','as'=>'movements.'], function(){
        Route::get('/', [MovementController::class,'index_all'])->name('index_all');
        Route::get('{user_id}', [MovementController::class,'index'])->name('index');
        Route::post('/', [MovementController::class,'store'])->name('store');
        Route::delete('{id}', [MovementController::class,'destroy'])->name('destroy');
    });
    
    Route::post('filters', [FiltersController::class,'export'])->name('filters');
    
    Route::group(['prefix'=>'balance','as'=>'balance.'], function(){
        Route::get('/{user_id}', [BalanceController::class,'index'])->name('index');
        Route::put('/', [BalanceController::class,'update'])->name('update'); 
    });
 
    /* AUTH ROUTES */
    Route::post('signup', [UsersAuthController::class,'store'])->name('signup');
    Route::post('signin', [LoginController::class,'store'])->name('login'); 
 
    /* PRIVATE ROUTES */
    Route::middleware('auth:api')->group(function () { 
        
        Route::get('profile', [UsersAuthController::class,'profile'])->name('profile');
        Route::put('profile', [UsersAuthController::class,'update'])->name('profile.update');
        Route::delete('profile', [UsersAuthController::class,'destroy'])->name('profile.destroy');

        Route::delete('signout', [LoginController::class,'destroy'])->name('signout'); 

        Route::group(['prefix'=>'movements-auth','as'=>'movements.auth.'], function(){
            Route::get('/', [MovementsAuthController::class,'index'])->name('index');
            Route::post('/', [MovementsAuthController::class,'store'])->name('store');
            Route::delete('{id}', [MovementsAuthController::class,'destroy'])->name('destroy');
        });

        Route::post('filters-auth', [FiltersController::class,'export'])->name('filters.auth');

        Route::group(['prefix'=>'balance-auth','as'=>'balance.auth.'], function(){
            Route::get('/', [BalanceAuthController::class,'index'])->name('index');
            Route::put('/', [BalanceAuthController::class,'update'])->name('update'); 
        }); 
    }); 
     
});