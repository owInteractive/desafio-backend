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
      await TransactionSequelize.create({
        ...transaction,
        to: to.id,
        from: from.id,
      })
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
      expect(transaction.chargebackFrom.id).toEqual(
        mockedChargebackTransaction.id
      )

      const transactionExists = await TransactionSequelize.findByPk(
        transaction.id
      )
      expect(transactionExists).toBeTruthy()
      expect(transactionExists.toJSON().id).toBe(transaction.id)
    })
  })

  describe('loadByUser()', () => {
    test('should return an empty array with the pagination if no transactions are found', async () => {
      const sut = makeSut()
      const user = await makeUser()
      const transactions = await sut.loadByUser({
        userId: user.id,
        page: 1,
        perPage: 10,
      })
      expect(transactions).toEqual({
        data: [],
        pagination: {
          page: 1,
          perPage: 10,
          total: 0,
          totalPages: 0,
        },
      })
    })

    test('should return valid pagination if transactions was found', async () => {
      const sut = makeSut()
      const userOne = await makeUser()
      const userTwo = await makeUser()
      const transactionOne = mockAddTransaction()
      transactionOne.to = userOne.id
      transactionOne.from = userTwo.id
      const transactionTwo = mockAddTransaction()
      transactionTwo.to = userOne.id
      transactionTwo.from = userTwo.id
      const transactionThree = mockAddTransaction()
      transactionThree.from = userOne.id
      transactionThree.to = userTwo.id

      const [transactionOneInserted] = await TransactionSequelize.bulkCreate([
        transactionOne,
        transactionTwo,
        transactionThree,
      ])
      const transactionsOfUserOne = await sut.loadByUser({
        userId: userOne.id,
        page: 1,
        perPage: 10,
      })

      expect(transactionsOfUserOne.pagination).toEqual({
        page: 1,
        perPage: 10,
        total: 3,
        totalPages: 1,
      })

      expect(transactionsOfUserOne.data[0].id).toBe(
        transactionOneInserted.getDataValue('id')
      )
      expect(transactionsOfUserOne.data[0].to.id).toEqual(userOne.id)
      expect(transactionsOfUserOne.data[0].from.id).toEqual(userTwo.id)
    })

    test('should change the page correctly', async () => {
      const sut = makeSut()
      const userOne = await makeUser()
      const userTwo = await makeUser()
      const transactionOne = mockAddTransaction()
      transactionOne.to = userOne.id
      transactionOne.from = userTwo.id
      const transactionTwo = mockAddTransaction()
      transactionTwo.to = userOne.id
      transactionTwo.from = userTwo.id
      const transactionThree = mockAddTransaction()
      transactionThree.from = userOne.id
      transactionThree.to = userTwo.id

      const [_, transactionTwoInserted] = await TransactionSequelize.bulkCreate(
        [transactionOne, transactionTwo, transactionThree]
      )
      const transactionsOfUserOne = await sut.loadByUser({
        userId: userOne.id,
        page: 2,
        perPage: 1,
      })

      expect(transactionsOfUserOne.pagination).toEqual({
        page: 2,
        perPage: 1,
        total: 3,
        totalPages: 3,
      })

      expect(transactionsOfUserOne.data[0].id).toBe(
        transactionTwoInserted.getDataValue('id')
      )
      expect(transactionsOfUserOne.data[0].to.id).toEqual(userOne.id)
      expect(transactionsOfUserOne.data[0].from.id).toEqual(userTwo.id)
    })
  })

  describe('deleteById()', () => {
    test('should return true if the transaction was deleted', async () => {
      const sut = makeSut()
      const transaction = await makeTransaction()
      const transactionExists = await TransactionSequelize.findByPk(
        transaction.id
      )
      expect(transactionExists).toBeTruthy()
      const result = await sut.deleteById({ id: transaction.id })
      const transactionAfterDelete = await TransactionSequelize.findByPk(
        transaction.id
      )

      expect(result).toBe(true)
      expect(transactionAfterDelete).toBeFalsy()
    })

    test('should return false if the transaction was not deleted', async () => {
      const sut = makeSut()
      const deleted = await sut.deleteById({ id: 1 })
      expect(deleted).toBe(false)
    })
  })

  describe('load()', () => {
    test('should return an empty array no transactions are found', async () => {
      const sut = makeSut()
      const transactions = await sut.load()
      expect(transactions).toEqual([])
    })

    test('should filter only the transactions of the lastDays provided', async () => {
      const sut = makeSut()
      const userOne = await makeUser()
      const userTwo = await makeUser()
      const transactionOne = mockAddTransaction()
      transactionOne.to = userOne.id
      transactionOne.from = userTwo.id
      const transactionTwo = mockAddTransaction()
      transactionTwo.to = userOne.id
      transactionTwo.from = userTwo.id
      const transactionThree = mockAddTransaction()
      transactionThree.from = userOne.id
      transactionThree.to = userTwo.id

      const [insertedTransactionOne] = await TransactionSequelize.bulkCreate([
        transactionOne,
        transactionTwo,
        transactionThree,
      ])

      await TransactionSequelize.update(
        {
          createdAt: new Date('2020-01-01'),
        },
        {
          where: {
            id: insertedTransactionOne.getDataValue('id'),
          },
        }
      )

      const transactions = await sut.load({
        lastDays: 1,
      })

      expect(transactions.length).toBe(2)
    })

    test('should filter only the transactions of the monthAndYear provided', async () => {
      const sut = makeSut()
      const userOne = await makeUser()
      const userTwo = await makeUser()
      const transactionOne = mockAddTransaction()
      transactionOne.to = userOne.id
      transactionOne.from = userTwo.id
      const transactionTwo = mockAddTransaction()
      transactionTwo.to = userOne.id
      transactionTwo.from = userTwo.id
      const transactionThree = mockAddTransaction()
      transactionThree.from = userOne.id
      transactionThree.to = userTwo.id
      const month = 1
      const year = 20
      const monthAndYear = `${month}/${year}`

      const [insertedTransactionOne] = await TransactionSequelize.bulkCreate([
        transactionOne,
        transactionTwo,
        transactionThree,
      ])

      await TransactionSequelize.update(
        {
          createdAt: new Date(2020, 0, 1),
        },
        {
          where: {
            id: insertedTransactionOne.getDataValue('id'),
          },
        }
      )

      const transactions = await sut.load({
        monthAndYear,
      })

      expect(transactions[0].id).toBe(insertedTransactionOne.getDataValue('id'))
    })
  })
})
