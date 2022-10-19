import { AddTransactionRepository } from '@/data/protocols/database/transactions/add-transaction-repository'
import TransactionSequelize from '../models/Transaction'
import UsersSequelize from '../models/User'

export class TransactionsMySqlReposiory implements AddTransactionRepository {
  async add(
    transaction: AddTransactionRepository.Params
  ): Promise<AddTransactionRepository.Result> {
    const newTransaction = await TransactionSequelize.create(transaction, {
      include: {
        all: true,
        nested: true
      }
    })
    return newTransaction as any as AddTransactionRepository.Result
  }
}
