/* eslint-disable @typescript-eslint/no-misused-promises */
import { Router } from 'express'
import { adaptRoute } from '../adapters/express/express-route-adapter'
import { makeAddTransactionController, makeLoadTransactionsByUserController } from '../factories/controllers/transaction'
import { makeDeleteTransactionByIdController } from '../factories/controllers/transaction/delete-transaction-by-id-controller-factory'

export const transactionsRoutes = (router: Router): void => {
  router.get('/transactions', adaptRoute(makeLoadTransactionsByUserController()))
  router.post('/transactions', adaptRoute(makeAddTransactionController()))
  router.delete('/transactions/:id', adaptRoute(makeDeleteTransactionByIdController()))
}
