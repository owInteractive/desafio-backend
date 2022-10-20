import { DbLoadTransactions } from "@/data/usecases/transactions";
import { LoadTransactions } from "@/domain/usecases/transactions";
import { TransactionsMySqlReposiory } from "@/infra/database/sequelize/TransactionsMySqlRepository/transactions-mysql.repository";

export function makeLoadTransactionsUseCase(): LoadTransactions {
  return new DbLoadTransactions(
    new TransactionsMySqlReposiory(),
  )
}