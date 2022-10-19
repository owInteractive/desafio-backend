import { DbAddTransaction } from "@/data/usecases/transactions/db-add-transaction";
import { AddTransaction } from "@/domain/usecases/transactions";
import { TransactionsMySqlReposiory } from "@/infra/database/sequelize/TransactionsMySqlRepository/transactions-mysql.repository";
import { UsersMySqlReposiory } from "@/infra/database/sequelize/UsersMySqlRepository/users-mysql-repository";

export function makeAddTransactionUseCase(): AddTransaction {
  return new DbAddTransaction(
    new TransactionsMySqlReposiory(),
    new UsersMySqlReposiory()
  )
}