<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\MovementController;
use App\Http\Controllers\Api\FiltersController;

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

    Route::get('movements', [MovementController::class,'index_all'])->name('movements.index_all');
    Route::get('movements/{user_id}', [MovementController::class,'index'])->name('movements.index');
    Route::post('movements', [MovementController::class,'store'])->name('movements.store');
    Route::delete('movements/{id}', [MovementController::class,'destroy'])->name('movements.destroy');
    Route::post('filters', [FiltersController::class,'export'])->name('movements.store');

});