/* eslint-disable @typescript-eslint/no-misused-promises */
import { Router } from 'express'
import { adaptRoute } from '../adapters/express/express-route-adapter'
import { makeAddUserController, makeLoadUsersController } from '../factories/controllers/user'
import { makeDeleteUserController } from '../factories/controllers/user/delete-user-controller-factory'
import { makeLoadUsersByIdController } from '../factories/controllers/user/load-user-by-id-controller-factory'

export const usersRoutes = (router: Router): void => {
  router.get('/users', adaptRoute(makeLoadUsersController()))
  router.get('/users/:id', adaptRoute(makeLoadUsersByIdController()))
  router.post('/users', adaptRoute(makeAddUserController()))
  router.delete('/users/:id', adaptRoute(makeDeleteUserController()))
}
