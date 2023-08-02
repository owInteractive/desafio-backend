<?php

use App\Http\Controllers\Api\MovimentacaoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resources([
    'users' => UserController::class,
    'movimentacoes' => MovimentacaoController::class,
]);
Route::post('/movimentacoes_export', [MovimentacaoController::class, 'export']);
Route::get('/users_desc', 'App\Http\Controllers\Api\UserController@desc')->name('users.desc');
// Route::get('users', 'App\Http\Controllers\Api\UserController@index')->name('users.perfil');
Route::get('/somamovimentacao/{id}', 'App\Http\Controllers\Api\UserController@somamovimentacao')->name('users.somamovimentacao');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
