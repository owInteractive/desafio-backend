import { LoadTransactionsRepository } from '@/data/protocols/database/transactions/load-transactions-repository'
import { LoadTransactions } from '@/domain/usecases/transactions'

export class DbLoadTransactions implements LoadTransactions {
  constructor(
    private readonly loadTransactionsRepository: LoadTransactionsRepository
  ) {}

  async load(
    params: LoadTransactions.Params
  ): Promise<LoadTransactions.Result> {
    const transactions = await this.loadTransactionsRepository.load(
      params
    )
    return transactions
  }
}
