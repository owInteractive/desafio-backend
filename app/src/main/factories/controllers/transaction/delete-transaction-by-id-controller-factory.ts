import {DeleteTransactionByIdController } from "@/presentation/controllers/transactions-controllers"
import { Controller } from "@/presentation/protocols"
import { makeDeleteTransactionByIdUseCase } from "../../usecases/transaction"

export function makeDeleteTransactionByIdController(): Controller {
  const deleteTransactionByIdUseCase = makeDeleteTransactionByIdUseCase()

  return new DeleteTransactionByIdController(deleteTransactionByIdUseCase)
}