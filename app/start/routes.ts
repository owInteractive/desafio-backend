/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| This file is dedicated for defining HTTP routes. A single file is enough
| for majority of projects, however you can define routes in different
| files and just make sure to import them inside this file. For example
|
| Define routes in following two files
| ├── start/routes/cart.ts
| ├── start/routes/customer.ts
|
| and then import them inside `start/routes.ts` as follows
|
| import './routes/cart'
| import './routes/customer'
|
*/

import Route from '@ioc:Adonis/Core/Route'

Route.get('/users','UsersController.get')
Route.get('/users/:id','UsersController.getById')
Route.delete('/users/:id','UsersController.delete')
Route.post('/users','UsersController.post')
Route.put('/users','UsersController.put')

Route.get('/transactions/:user_id','TransactionsController.get')
Route.post('/transactions','TransactionsController.post')
Route.delete('/transactions','TransactionsController.delete')