import { DbDeleteTransactionById } from "@/data/usecases/transactions/db-delete-transaction-by-id";
import { DeleteTransactionById } from "@/domain/usecases/transactions";
import { TransactionsMySqlReposiory } from "@/infra/database/sequelize/TransactionsMySqlRepository/transactions-mysql.repository";

export function makeDeleteTransactionByIdUseCase(): DeleteTransactionById {
  return new DbDeleteTransactionById(
    new TransactionsMySqlReposiory(),
  )
}