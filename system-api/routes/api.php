<?php

use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\map;

/*

API ROUTES

*/

// User routes

Route::post('user', [
    'as' => 'user.store',
    'uses' => 'UserController@storeUser'
]);

Route::get('users', [
    'as' => 'users.list',
    'uses' => 'UserController@listUsers'
]);

Route::get('user/{id}',[
    'as' => 'user.show',
    'uses' => 'UserController@showUser'
]);

Route::delete('user/{id}', [
    'as' => 'user.delete',
    'uses' => 'UserController@destroyUser'
]);

Route::put('updateOpeningBalance/{id}',[
    'as' => 'user.update_opening_balance',
    'uses' => 'UserController@updateOpeningBalance'
]);

// Operation routes

Route::post('operation', [
    'as' => 'operation.store',
    'uses' => 'OperationController@storeOperation'
]);

Route::get('operation/{id}', [
    'as' => 'operation.show',
    'uses' => 'OperationController@showOperation'
]);

Route::delete('operation/{user_id}/{operation_id}',[
    'as' => 'operation.delete',
    'uses' => 'OperationController@destroyOperation'
]);

Route::get('operationReport/{param}',[
    'as' => 'operationReport',
    'uses' => 'OperationController@operationReport'
]);

Route::get('totalOperations/{id}', [
    'as' => 'totalOperations',
    'uses' => 'OperationController@totalOperations'
]);

Route::get ('exportCSV/{filter}',[
    'as' => 'exportCSV',
    'uses' => 'OperationController@exportCSV'
]);

Route::get ('exportCSV/{filter}/{user_id}',[
    'as' => 'exportCSV',
    'uses' => 'OperationController@exportCSV'
]);

// Route Fallback

Route::fallback(function () {
    return response()->json([
        'message' => 'Rota não encontrada.'
    ], 404);
});
