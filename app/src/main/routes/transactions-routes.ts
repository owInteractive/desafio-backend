/* eslint-disable @typescript-eslint/no-misused-promises */
import { Router } from 'express'
import { adaptRoute } from '../adapters/express/express-route-adapter'
import { makeAddTransactionController, makeLoadTransactionsByUserController } from '../factories/controllers/transaction'
import { makeDeleteTransactionByIdController } from '../factories/controllers/transaction/delete-transaction-by-id-controller-factory'
import { makeLoadTransactionsCsvController } from '../factories/controllers/transaction/load-transactions-csv-controller'

export const transactionsRoutes = (router: Router): void => {
  router.get('/transactions', adaptRoute(makeLoadTransactionsByUserController()))
  router.get('/transactions/csv', adaptRoute(makeLoadTransactionsCsvController()))
  router.post('/transactions', adaptRoute(makeAddTransactionController()))
  router.delete('/transactions/:id', adaptRoute(makeDeleteTransactionByIdController()))
}
