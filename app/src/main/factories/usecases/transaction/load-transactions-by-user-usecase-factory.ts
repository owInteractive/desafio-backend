import { DbLoadTransactionByUser } from "@/data/usecases/transactions/db-load-transaction-by-user";
import { LoadTransactionByUser } from "@/domain/usecases/transactions";
import { TransactionsMySqlReposiory } from "@/infra/database/sequelize/TransactionsMySqlRepository/transactions-mysql.repository";

export function makeLoadTransactionsByUserUseCase(): LoadTransactionByUser {
  return new DbLoadTransactionByUser(
    new TransactionsMySqlReposiory(),
  )
}