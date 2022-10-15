/* eslint-disable @typescript-eslint/no-misused-promises */
import { Router } from 'express'
import { adaptRoute } from '../adapters/express/express-route-adapter'
import { makeAddUserController } from '../factories/controllers/user/add-user-controller-factory'

export const usersRoutes = (router: Router): void => {
  router.post('/users', adaptRoute(makeAddUserController()))
}
