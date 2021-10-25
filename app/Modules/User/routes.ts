/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|
| This file is dedicated for defining HTTP routes from users.
|
*/

import Route from '@ioc:Adonis/Core/Route'

Route.group(() => {
  Route.get('/', 'UsersController.index')
  Route.post('/', 'UsersController.store')
  Route.get('/:id', 'UsersController.show')
  Route.delete('/:id', 'UsersController.destroy')

  Route.post('balance/:id', 'UsersController.balance')
}).prefix('/users')
