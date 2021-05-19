<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Rotas de usuários
Route::post('cadastra-usuario', [UserController::class, 'store']);
Route::get('listar-usuarios', [UserController::class, 'index']);
Route::get('listar-usuario/{id}', [UserController::class, 'show']);
Route::delete('excluir-usuario/{id}', [UserController::class, 'destroy']);

//Rotas conta bancária
Route::post('criar-conta', [AccountController::class, 'criarConta']);
Route::post('credito', [CreditController::class, 'credito']);
Route::post('debito', [DebitController::class, 'debito']);
