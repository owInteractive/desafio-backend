import { DeleteTransactionByIdRepositorySpy } from "@/data/test/mock-transactions";
import { faker } from "@faker-js/faker";
import { describe, expect, test, vitest } from "vitest";
import { DbDeleteTransactionById } from "./db-delete-transaction-by-id";

describe('DbDeleteTransactionById', () => {
  function makeSut() {
    const deleteTransactionByIdRepositorySpy = new DeleteTransactionByIdRepositorySpy()
    const sut = new DbDeleteTransactionById(
      deleteTransactionByIdRepositorySpy
    )

    return {
      sut,
      deleteTransactionByIdRepositorySpy
    }
  }
  describe('deleteById()', () => {
    test('should call loadTransactionByUserRepository with correct params', async () => {
      const { sut, deleteTransactionByIdRepositorySpy } = makeSut()
      const params = {
        id: faker.datatype.number(),
      }

      await sut.deleteById(params)
      expect(deleteTransactionByIdRepositorySpy.deleteByIdParams).toEqual(params)
    });

    test('should return true on success', async () => {
      const { sut } = makeSut()
      const params = {
        id: faker.datatype.number(),
      }

      const result = await sut.deleteById(params)
      expect(result).toBe(true)
    })

    test('should return false on fails', async () => {
      const { sut, deleteTransactionByIdRepositorySpy } = makeSut()
      deleteTransactionByIdRepositorySpy.deleteByIdResult = false
      const params = {
        id: faker.datatype.number(),
      }

      const result = await sut.deleteById(params)
      expect(result).toBe(false)
    });

    test('should throw if deleteTransactionById throws', async () => {
      const { sut, deleteTransactionByIdRepositorySpy } = makeSut()
      vitest.spyOn(deleteTransactionByIdRepositorySpy, 'deleteById').mockImplementationOnce(() => {
        throw new Error()
      })

      const params = {
        id: faker.datatype.number(),
      }

      await expect(sut.deleteById(params)).rejects.toThrow()
    });
  });
});