import { mockTransaction } from '@/domain/tests/mock-transactions'
import { AddTransactionRepository } from '../protocols/database/transactions/add-transaction-repository'

export class AddTransactionRepositorySpy implements AddTransactionRepository {
  addParams: AddTransactionRepository.Params
  addResult: AddTransactionRepository.Result
  constructor() {
    this.addResult = mockTransaction()
  }
  async add(
    params: AddTransactionRepository.Params
  ): Promise<AddTransactionRepository.Result> {
    this.addParams = params
    return Promise.resolve(this.addResult)
  }
}
