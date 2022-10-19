import { LoadTransactionByUserRepositorySpy } from "@/data/test/mock-transactions";
import { faker } from "@faker-js/faker";
import { describe, expect, test, vitest } from "vitest";
import { DbLoadTransactionByUser } from "./db-load-transaction-by-user";

describe('DbLoadTransactionByUser', () => {
  function makeSut() {
    const loadTransactionByUserRepositorySpy = new LoadTransactionByUserRepositorySpy()
    const sut = new DbLoadTransactionByUser(
      loadTransactionByUserRepositorySpy
    )

    return {
      sut,
      loadTransactionByUserRepositorySpy
    }
  }
  describe('lodByUser()', () => {
    test('should call loadTransactionByUserRepository with correct params', async () => {
      const { sut, loadTransactionByUserRepositorySpy } = makeSut()
      const params = {
        userId: faker.datatype.number(),
        page: faker.datatype.number(),
        perPage: faker.datatype.number()
      }

      await sut.loadByUser(params)
      expect(loadTransactionByUserRepositorySpy.loadByUserParams).toEqual(params)
    });

    test('should return user\'s transaction paginated', async () => {
      const { sut, loadTransactionByUserRepositorySpy } = makeSut()
      const result = await sut.loadByUser({
        userId: faker.datatype.number(),
        page: faker.datatype.number(),
        perPage: faker.datatype.number()
      })
      expect(result).toEqual(loadTransactionByUserRepositorySpy.loadByUserResult)
    });

    test('should throw if loadTransactionByUserRepository throws', async () => {
      const { sut, loadTransactionByUserRepositorySpy } = makeSut()
      const mockedError = new Error('some_error')
      vitest.spyOn(loadTransactionByUserRepositorySpy, 'loadByUser').mockRejectedValueOnce(mockedError)
      const promise = sut.loadByUser({
        userId: faker.datatype.number(),
        page: faker.datatype.number(),
        perPage: faker.datatype.number()
      })
      await expect(promise).rejects.toThrow(mockedError)
    });
  });
});