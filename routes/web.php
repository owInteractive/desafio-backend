<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Endpoint de início (GET).
Route::any('/', [UserController::class, 'start']);

// -------------------------- USUÁRIOS --------------------------

// Endpoint de registro de usuários (POST).
Route::any('/register', [UserController::class, 'register'])->name('register');

// Endpoint de registro de usuários (POST).
Route::any('/adduser', [UserController::class, 'addOne'])->name('adduser');

// Endpoint com uma listagem paginada das informações de todos os usuários cadastrados (POST).
Route::any('/listusers/{page_number}/{quantity_by_page}', [UserController::class, 'listAll'])->name('listusers');

// Endpoint com as informações de apenas um usuário cadastrado (POST).
Route::any('/listuser/{id}', [UserController::class, 'listOne'])->name('listuser');

// Endpoint de edição das informações de um usuário (PUT).
Route::any('/edituser/{id}', [UserController::class, 'editOne'])->name('edituser');

// Endpoint de remoção de um usuário (DELETE).
Route::any('/removeuser/{id}', [UserController::class, 'removeOne'])->name('removeuser');

// Endpoint do seeder de usuários (POST).
Route::any('/userseeder/{quantity}', [UserController::class, 'userSeeder'])->name('userseeder');

// -------------------------- TRANSAÇÕES --------------------------

// Endpoint de adição de transação (POST).
Route::any('/addcharge/{id}', [TransactionController::class, 'addCharge'])->name('addcharge');

// Endpoint com a listagem das transações de um usuário (POST).
Route::any('/listinformation/{id}/{page_number}/{quantity_by_page}', [TransactionController::class, 'listInformation'])->name('listinformation');

// Endpoint com a listagem das transações, incluindo os saldos inicial e atual (POST).
Route::any('/chargesreport/{id}/{filter}', [TransactionController::class, 'chargesReport'])->name('chargesrepost');

// Endpoint com a listagem das transações e dos saldos inicial e atual (POST).
Route::any('/sumtransactions/{id}', [TransactionController::class, 'sumTransactions'])->name('sumtransactions');

// Endpoint de edição do valor do saldo inicial (PUT).
Route::any('/editbalance/{id}', [TransactionController::class, 'editBalance'])->name('editbalance');

// Endpoint de remoção de uma transação de um usuário (DELETE).
Route::any('/removecharge/{id}', [TransactionController::class, 'removeCharge'])->name('removecharge');

// Endpoint do seeder de transações (POST).
Route::any('/transactionseeder/{id}/{quantity}', [TransactionController::class, 'transactionSeeder'])->name('transactionseeder');
