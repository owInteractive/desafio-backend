/*
|--------------------------------------------------------------------------
| Movements Routes
|--------------------------------------------------------------------------
|
| This file is dedicated for defining HTTP routes from movements.
|
*/

import Route from '@ioc:Adonis/Core/Route'

Route.group(() => {
  Route.post('/', 'MovementsController.store')
  Route.get('/:id', 'MovementsController.show')
  Route.delete('/:userId/:id', 'MovementsController.destroy')
}).prefix('/movements')
