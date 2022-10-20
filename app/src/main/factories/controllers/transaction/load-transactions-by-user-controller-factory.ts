import { LoadTransactionByUserController } from "@/presentation/controllers/transactions-controllers/load-transactions-by-user-controller"
import { Controller } from "@/presentation/protocols"
import { makeLoadTransactionsByUserUseCase } from "../../usecases/transaction/load-transactions-by-user-usecase-factory"
import { makeLoadTransactionsByUserControllerValidator } from "../../validators/transaction"

export function makeLoadTransactionsByUserController(): Controller {
  const loadTransactionByUserUseCase = makeLoadTransactionsByUserUseCase()
  const validation = makeLoadTransactionsByUserControllerValidator()

  return new LoadTransactionByUserController(loadTransactionByUserUseCase, validation)
}