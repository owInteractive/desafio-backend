import { mockTransaction } from '@/domain/tests/mock-transactions'
import { faker } from '@faker-js/faker'
import { AddTransactionRepository } from '../protocols/database/transactions/add-transaction-repository'
import { DeleteTransactionByIdRepository } from '../protocols/database/transactions/delete-transaction-by-id-repository'
import { LoadTransactionByUserRepository } from '../protocols/database/transactions/load-transaction-by-user-repository'
import { LoadTransactionsRepository } from '../protocols/database/transactions/load-transactions-repository'

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

export class LoadTransactionsRepositorySpy implements LoadTransactionsRepository {
  loadParams: LoadTransactionsRepository.Params
  loadResult: LoadTransactionsRepository.Result
  constructor() {
    this.loadResult = {
      data: [mockTransaction()],
      pagination: {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        total: faker.datatype.number(),
        totalPages: faker.datatype.number()
      }
    }
  }
  async load(params: LoadTransactionsRepository.Params): Promise<LoadTransactionByUserRepository.Result> {
    this.loadParams = params
    return this.loadResult
  }
}

export class DeleteTransactionByIdRepositorySpy implements DeleteTransactionByIdRepository {
  deleteByIdParams: DeleteTransactionByIdRepository.Params
  deleteByIdResult = true
  async deleteById(params: DeleteTransactionByIdRepository.Params): Promise<DeleteTransactionByIdRepository.Result> {
    this.deleteByIdParams = params
    return Promise.resolve(this.deleteByIdResult)
  }
}