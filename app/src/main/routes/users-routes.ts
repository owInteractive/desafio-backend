/* eslint-disable @typescript-eslint/no-misused-promises */
import { Router } from 'express'
import { adaptRoute } from '../adapters/express/express-route-adapter'
import { makeAddUserController } from '../factories/controllers/user/add-user-controller-factory'
import { makeLoadUsersController } from '../factories/controllers/user/load-users-controller-factory'

export const usersRoutes = (router: Router): void => {
  router.get('/users', adaptRoute(makeLoadUsersController()))
  router.get('/users/:id', adaptRoute(makeLoadUserByIdController()))
  router.post('/users', adaptRoute(makeAddUserController()))
}
