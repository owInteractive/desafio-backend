import { faker } from '@faker-js/faker'
import { AddTransactionModel, Transaction } from '../models'
import {
  AddTransaction,
  DeleteTransactionById,
  LoadTransactionByUser,
  LoadTransactions,
} from '../usecases/transactions'
import { mockPagination } from './mock-pagination'
import { mockUser } from './mock-users'

export function mockTransaction(): Transaction {
  return {
    id: faker.datatype.number(),
    amount: faker.datatype.float(),
    from: mockUser(),
    to: mockUser(),
    type: faker.helpers.arrayElement(['debt', 'credit', 'chargeback']),
    createdAt: faker.date.past(),
    chargebackFrom: null,
    description: faker.lorem.sentence(),
  }
}

export function mockAddTransaction(): AddTransactionModel {
  return {
    amount: faker.datatype.float(),
    from: mockUser().id,
    to: mockUser().id,
    type: faker.helpers.arrayElement(['debt', 'credit', 'chargeback']),
    chargebackFrom: null,
    description: faker.lorem.sentence(),
  }
}

export class AddTransactionSpy implements AddTransaction {
  addResult: AddTransaction.Result
  addParams: AddTransaction.Params
  constructor() {
    this.addResult = mockTransaction()
  }
  async add(params: AddTransaction.Params): Promise<AddTransaction.Result> {
    this.addParams = params
    return new Promise(resolve => resolve(this.addResult))
  }
}

export class LoadTransactionByUserSpy implements LoadTransactionByUser {
  loadByUserResult: LoadTransactionByUser.Result
  loadByUserParams: LoadTransactionByUser.Params
  constructor() {
    this.loadByUserResult = mockPagination<Transaction>([mockTransaction()])
  }
  async loadByUser(
    params: LoadTransactionByUser.Params
  ): Promise<LoadTransactionByUser.Result> {
    this.loadByUserParams = params
    return new Promise(resolve => resolve(this.loadByUserResult))
  }
}

export class LoadTransactionsSpy implements LoadTransactions {
  loadResult: LoadTransactions.Result
  loadParams: LoadTransactions.Params
  constructor() {
    this.loadResult = [mockTransaction()]
  }
  async load(
    params: LoadTransactions.Params
  ): Promise<LoadTransactions.Result> {
    this.loadParams = params
    return new Promise(resolve => resolve(this.loadResult))
  }
}

export class DeleteTransactionByIdSpy implements DeleteTransactionById {
  deleteByIdResult: DeleteTransactionById.Result
  deleteByIdParams: DeleteTransactionById.Params
  constructor() {
    this.deleteByIdResult = true
  }
  async deleteById(
    params: DeleteTransactionById.Params
  ): Promise<DeleteTransactionById.Result> {
    this.deleteByIdParams = params
    return new Promise(resolve => resolve(this.deleteByIdResult))
  }
}
