<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovesController;

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

Route::get('/ping', function() {
    return ['pong' => true]; 
});

// Não autorizado
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

// ROTAS DE LOGIN E REGISTRO
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// ROTAS DE INFORMAÇÕES USUARIOS
Route::get('/users', [UserController::class, 'getAll']);
Route::get('/user/{id}', [UserController::class, 'getUser']);
Route::put('/user/{id}', [userController::class, 'editBalance']);
Route::delete('/user/{id}', [UserController::class, 'deleteUser']);

// ROTAS DE EXPORTAÇÃO DE ARQUIVOS .CSV
Route::get('/moves_export', [MovesController::class, 'export']);
Route::get('/moves30_export', [MovesController::class, 'export30days']);

// ROTAS QUE SÃO NECESSARIO AUTENTICAÇÃO
Route::middleware('auth:api')->group(function() {
    Route::get('/moves', [MovesController::class, 'getMovements']);
    Route::post('/movement', [MovesController::class, 'movement']);
    Route::post('/movement/{id}/delete', [MovesController::class, 'delMovement']);
});