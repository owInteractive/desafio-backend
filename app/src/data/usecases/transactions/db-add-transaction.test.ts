import { AddTransactionRepositorySpy } from "@/data/test/mock-transactions";
import { LoadUsersByIdRepositorySpy } from "@/data/test/mock-users";
import { mockAddTransaction } from "@/domain/tests/mock-transactions";
import { NotFoundError } from "@/presentation/errors";
import { describe, expect, test, vitest } from "vitest";
import { DbAddTransaction } from "./db-add-transaction";

describe('DbAddTransaction', () => {
  function makeSut() {
    const addTransactionRepositorySpy = new AddTransactionRepositorySpy()
    const loadUsersByIdRepository = new LoadUsersByIdRepositorySpy()
    const sut = new DbAddTransaction(addTransactionRepositorySpy, loadUsersByIdRepository);
    return {
      sut,
      addTransactionRepositorySpy,
      loadUsersByIdRepository
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

    test('should call loadUsersByIdRepository with the user that make the transaction', async () => {
      const { sut, loadUsersByIdRepository } = makeSut()
      const mockedAddTransaction = mockAddTransaction()
      await sut.add(mockedAddTransaction)
      expect(loadUsersByIdRepository.loadByIdParams[0]).toEqual({userId: mockedAddTransaction.from})
    });

    test('should call loadUsersByIdRepository with the user that will receive the transaction', async () => {
      const { sut, loadUsersByIdRepository } = makeSut()
      const mockedAddTransaction = mockAddTransaction()
      await sut.add(mockedAddTransaction)
      expect(loadUsersByIdRepository.loadByIdParams[1]).toEqual({userId: mockedAddTransaction.to})
    });

    test('should throw not found if loadUsersById returns null', async () => {
      const { sut, loadUsersByIdRepository } = makeSut()
      const mockedAddTransaction = mockAddTransaction()
      loadUsersByIdRepository.loadByIdResult = null
      const promise = sut.add(mockedAddTransaction)
      await expect(promise).rejects.toBeInstanceOf(NotFoundError)
    });
  });
});