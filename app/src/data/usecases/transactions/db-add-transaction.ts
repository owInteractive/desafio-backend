import { AddTransactionRepository } from "@/data/protocols/database/transactions/add-transaction-repository"
import { AddTransaction } from "@/domain/usecases/transactions"

export class DbAddTransaction {
  constructor (
    private readonly addTransactionRepository: AddTransactionRepository
  ) {}

  async add (params: AddTransaction.Params): Promise<AddTransaction.Result> {
    return this.addTransactionRepository.add(params)
  }
}