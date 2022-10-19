import { mockTransaction } from '@/domain/tests/mock-transactions'
import { faker } from '@faker-js/faker'
import { AddTransactionRepository } from '../protocols/database/transactions/add-transaction-repository'
import { LoadTransactionByUserRepository } from '../protocols/database/transactions/load-transaction-by-user-repository'

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


export class LoadTransactionByUserRepositorySpy implements LoadTransactionByUserRepository {
  loadByUserParams: LoadTransactionByUserRepository.Params
  loadByUserResult: LoadTransactionByUserRepository.Result
  constructor() {
    this.loadByUserResult = {
      data: [mockTransaction()],
      pagination: {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        total: faker.datatype.number(),
        totalPages: faker.datatype.number()
      }
    }
  }
  async loadByUser(params: LoadTransactionByUserRepository.Params): Promise<LoadTransactionByUserRepository.Result> {
    this.loadByUserParams = params
    return this.loadByUserResult
  }
}