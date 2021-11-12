<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/users', 'UsersController@index');
$router->get('/users/{id}', 'UsersController@show');
$router->get('/users/{id}/{value}', 'UsersController@add');
$router->post('/users', 'UsersController@store');
$router->delete('/users/{id}', 'UsersController@destroy');



$router->group(['prefix' => '/transaction'], function () use ($router) {
    $router->get('/show/{id}', 'TransactionsController@index');
    $router->get('/debit/{id}/{value}', 'TransactionsController@debit');
    $router->get('/credit/{id}/{value}', 'TransactionsController@credit');
    $router->post('/chargeback/{id}', 'TransactionsController@chargeback');
    $router->delete('/delete-transaction/{id}/{transaction}', 'TransactionsController@destroyTransaction');
});

$router->group(['prefix' => '/export'], function () use ($router) {
    $router->get('/{id}/{month}-{year}', 'ExportController@last');

});
