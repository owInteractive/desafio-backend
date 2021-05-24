<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\MoveDeleteController;
use App\Http\Controllers\MovimentacoesController;
use App\Http\Controllers\ReversalController;
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
Route::post('altera-saldo-inicial', [UserController::class, 'alteraSaldoInicial']);
Route::get('listar-usuarios', [UserController::class, 'index']);
Route::get('listar-usuario/{id}', [UserController::class, 'show']);
Route::delete('excluir-usuario/{id}', [UserController::class, 'destroy']);

//Rotas das Movimentações 
Route::post('associar-movimentacao', [MovimentacoesController::class, 'associaMovimentacao']);
Route::get('listar-movimentacoes', [MovimentacoesController::class, 'extrato']);
Route::delete('excluir-movimentacao/{id}', [MovimentacoesController::class, 'excluirMovimentacao']);
Route::get('csv/{filtro}', [MovimentacoesController::class, 'esportaCsv']);
Route::get('soma-movimentacoes', [MovimentacoesController::class, 'somaMovimentacoes']);



