import { faker } from "@faker-js/faker";
import { AddTransactionModel, Transaction } from "../models";
import { AddTransaction } from "../usecases/transactions";
import { mockUser } from "./mock-users";

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
    return new Promise((resolve) => resolve(this.addResult))
  }
}