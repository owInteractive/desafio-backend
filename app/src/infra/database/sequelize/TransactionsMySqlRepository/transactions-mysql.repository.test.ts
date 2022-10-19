import { Transaction, User } from '@/domain/models'
import { mockAddTransaction } from '@/domain/tests/mock-transactions'
import { mockAddUser } from '@/domain/tests/mock-users'
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest'
import TransactionSequelize from '../models/Transaction'
import UsersSequelize from '../models/User'
import { migrate, truncate } from '../__tests__/utils'
import { TransactionsMySqlReposiory } from './transactions-mysql.repository'

describe('TransactionsMySqlRepository', () => {
  function makeSut() {
    return new TransactionsMySqlReposiory()
  }

  function makeUser(): Promise<User> {
    const user = mockAddUser()
    return UsersSequelize.create(user) as any
  }

  async function makeTransaction(): Promise<Transaction> {
    const transaction = mockAddTransaction()
    const to = await makeUser()
    const from = await makeUser()
    const rawTransactionDb = (
      await TransactionSequelize.create({...transaction, to: to.id, from: from.id})
    ).toJSON()

    const { From, ChargebackFrom, To, ...transactionDb } = (
      await TransactionSequelize.findOne({
        where: {
          id: rawTransactionDb.id,
        },
        include: {
          all: true,
        },
      })
    ).toJSON()
    const transactionMapped = {
      ...transactionDb,
      from: From,
      to: To,
      chargebackFrom: ChargebackFrom,
    }

    return transactionMapped
  }

  beforeAll(async () => {
    await migrate()
  })

  afterAll(async () => {
    await truncate()
  })

  beforeEach(async () => {
    await truncate()
    await migrate()
  })
  describe('add()', () => {
    test('should add and return an transaction on success ', async () => {
      const sut = makeSut()
      const to = await makeUser()
      const from = await makeUser()
      const mockedTransaction = mockAddTransaction()
      mockedTransaction.to = to.id
      mockedTransaction.from = from.id
      const transaction = await sut.add(mockedTransaction)

      expect(transaction.amount).toBe(mockedTransaction.amount)
      expect(transaction.description).toBe(mockedTransaction.description)
      expect(transaction.type).toBe(mockedTransaction.type)
      expect(transaction.to.id).toEqual(to.id)
      expect(transaction.from.id).toEqual(from.id)

      const transactionExists = await TransactionSequelize.findByPk(
        transaction.id
      )
      expect(transactionExists).toBeTruthy()
      expect(transactionExists.toJSON().id).toBe(transaction.id)
    })

    test('should add and return an transaction on success ', async () => {
      const sut = makeSut()
      const to = await makeUser()
      const from = await makeUser()
      const mockedChargebackTransaction = await makeTransaction()
      
      const mockedTransaction = mockAddTransaction()
      mockedTransaction.to = to.id
      mockedTransaction.from = from.id
      mockedTransaction.type = 'chargeback'
      mockedTransaction.chargebackFrom = mockedChargebackTransaction.id
      const transaction = await sut.add(mockedTransaction)

      expect(transaction.amount).toBe(mockedTransaction.amount)
      expect(transaction.description).toBe(mockedTransaction.description)
      expect(transaction.type).toBe(mockedTransaction.type)
      expect(transaction.to.id).toEqual(to.id)
      expect(transaction.from.id).toEqual(from.id)
      expect(transaction.chargebackFrom.id).toEqual(mockedChargebackTransaction.id)
      
      const transactionExists = await TransactionSequelize.findByPk(
        transaction.id
      )
      expect(transactionExists).toBeTruthy()
      expect(transactionExists.toJSON().id).toBe(transaction.id)
    })
  })
})
