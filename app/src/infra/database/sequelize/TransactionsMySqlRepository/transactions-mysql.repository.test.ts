import { User } from '@/domain/models'
import { mockAddTransaction } from '@/domain/tests/mock-transactions'
import { mockAddUser } from '@/domain/tests/mock-users'
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest'
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
      mockedTransaction.to = to
      mockedTransaction.from = from
      const transaction = await sut.add(mockedTransaction)

      expect(transaction.amount).toBe(mockedTransaction.amount)
      expect(transaction.description).toBe(mockedTransaction.description)
      expect(transaction.type).toBe(mockedTransaction.type)
      expect(transaction.to.id).toEqual(to.id)
      expect(transaction.from.id).toEqual(from.id)
      
    })
  })
})
