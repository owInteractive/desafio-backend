import { LoadTransactionsRepositorySpy } from '@/data/test/mock-transactions'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { DbLoadTransactions } from './db-load-transactions'

describe('DbLoadTransactions', () => {
  function makeSut() {
    const loadTransactionsRepositorySpy = new LoadTransactionsRepositorySpy()
    const sut = new DbLoadTransactions(loadTransactionsRepositorySpy)

    return {
      sut,
      loadTransactionsRepositorySpy,
    }
  }
  describe('load()', () => {
    test('should call loadTransactionsRepository with correct params', async () => {
      const { sut, loadTransactionsRepositorySpy } = makeSut()
      const params = {
        userId: faker.datatype.number(),
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
      }

      await sut.load(params)
      expect(loadTransactionsRepositorySpy.load).toEqual(params)
    })

    test("should return user's transaction paginated", async () => {
      const someDate = faker.date.recent()
      const monthAndYear = `${
        someDate.getMonth() + 1
      }/${someDate.getFullYear()}`
      const { sut, loadTransactionsRepositorySpy } = makeSut()
      const result = await sut.load({
        lastDays: faker.datatype.number(),
        monthAndYear,
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
      })
      expect(result).toEqual(loadTransactionsRepositorySpy.loadResult)
    })

    test('should throw if loadTransactionsRepository throws', async () => {
      const { sut, loadTransactionsRepositorySpy } = makeSut()
      const mockedError = new Error('some_error')
      vitest
        .spyOn(loadTransactionsRepositorySpy, 'load')
        .mockRejectedValueOnce(mockedError)
      const promise = sut.load({
        lastDays: faker.datatype.number(),
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
      })
      await expect(promise).rejects.toThrow(mockedError)
    })
  })
})
