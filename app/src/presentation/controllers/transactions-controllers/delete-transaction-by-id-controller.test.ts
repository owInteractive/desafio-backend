import { DeleteTransactionByIdSpy } from '@/domain/tests/mock-transactions'
import { notFound, ok, serverError } from '@/presentation/helpers/http-helper'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { DeleteTransactionByIdController } from './delete-transaction-by-id-controller'

describe('DeleteTransactionByIdController', () => {
  function makeSut() {
    const deleteTransactionByIdSpy = new DeleteTransactionByIdSpy()
    const sut = new DeleteTransactionByIdController(deleteTransactionByIdSpy)
    return {
      sut,
      deleteTransactionByIdSpy,
    }
  }
  describe('handle()', () => {
    test('should call deleteTransactionByIdUseCase with correct id', async () => {
      const { sut, deleteTransactionByIdSpy } = makeSut()
      const request = {
        id: faker.datatype.number(),
      }
      await sut.handle(request)
      expect(deleteTransactionByIdSpy.deleteByIdParams).toEqual({
        id: request.id,
      })
    })

    test('should return NotFound if deleteTransactionByIdUseCase returns false', async () => {
      const { sut, deleteTransactionByIdSpy } = makeSut()
      deleteTransactionByIdSpy.deleteByIdResult = false
      const request = {
        id: faker.datatype.number(),
      }
      const result = await sut.handle(request)
      expect(result).toEqual(
        notFound('transaction', `Transaction ${request.id} does not exits`)
      )
    })

    test('should return ok with success on success', async () => {
      const { sut } = makeSut()
      const request = {
        id: faker.datatype.number(),
      }
      const result = await sut.handle(request)
      expect(result).toEqual(ok({ success: true }))
    })

    test('should return server error if deleteTransactionByIdUseCase throws', async () => {
      const { sut, deleteTransactionByIdSpy } = makeSut()
      const mockedError = new Error('mocked error')
      vitest
        .spyOn(deleteTransactionByIdSpy, 'deleteById')
        .mockRejectedValueOnce(mockedError)
      const request = {
        id: faker.datatype.number(),
      }

      const result = await sut.handle(request)
      expect(result).toEqual(serverError(mockedError))
    })
  })
})
