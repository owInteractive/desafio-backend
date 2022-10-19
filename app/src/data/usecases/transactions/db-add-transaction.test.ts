import { AddTransactionRepositorySpy } from "@/data/test/mock-transactions";
import { mockAddTransaction } from "@/domain/tests/mock-transactions";
import { describe, expect, test, vitest } from "vitest";
import { DbAddTransaction } from "./db-add-transaction";

describe('DbAddTransaction', () => {
  function makeSut() {
    const addTransactionRepositorySpy = new AddTransactionRepositorySpy()
    const sut = new DbAddTransaction(addTransactionRepositorySpy);
    return {
      sut,
      addTransactionRepositorySpy
    }
  }
  describe('add()', () => {
    test('should call addTransactionRepository with correct params', async () => {
      const { sut, addTransactionRepositorySpy } = makeSut()
      const mockedAddTransaction = mockAddTransaction()
      await sut.add(mockedAddTransaction)
      expect(addTransactionRepositorySpy.addParams).toEqual(mockedAddTransaction)
    });

    test('should throw if addTransactionRepository throws', async () => {
      const { sut, addTransactionRepositorySpy } = makeSut()
      const mockedError = new Error('some_erorr')
      vitest.spyOn(addTransactionRepositorySpy, 'add').mockRejectedValueOnce(mockedError)
      const mockedAddTransaction = mockAddTransaction()
      const promise = sut.add(mockedAddTransaction)
      await expect(promise).rejects.toThrow(mockedError)
    });
  });
});