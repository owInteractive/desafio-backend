import { AddTransactionController } from "@/presentation/controllers/transactions-controllers";
import { Controller } from "@/presentation/protocols";
import { makeAddTransactionUseCase } from "../../usecases/transaction";
import { makeAddTransactionControllerValidator } from "../../validators/transaction/add-transaction-controller-validator-factory";

export function makeAddTransactionController(): Controller {
  return new AddTransactionController(
    makeAddTransactionUseCase(),
    makeAddTransactionControllerValidator()
  )
}