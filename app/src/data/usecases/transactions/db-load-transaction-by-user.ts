import { LoadTransactionByUserRepository } from '@/data/protocols/database/transactions/load-transaction-by-user-repository'
import { LoadTransactionByUser } from '@/domain/usecases/transactions'

export class DbLoadTransactionByUser implements LoadTransactionByUser {
  constructor(
    private readonly loadTransactionByUserRepository: LoadTransactionByUserRepository
  ) {}

  async loadByUser(
    params: LoadTransactionByUser.Params
  ): Promise<LoadTransactionByUser.Result> {
    const usersTransactions = await this.loadTransactionByUserRepository.loadByUser(params)
    return usersTransactions
  }
}
