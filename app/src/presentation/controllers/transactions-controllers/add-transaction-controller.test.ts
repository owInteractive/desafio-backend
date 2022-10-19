import {
  AddTransactionSpy,
  mockAddTransaction,
} from '@/domain/tests/mock-transactions'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { ValidationSpy } from '@/validation/test/mock-validation'
import { describe, expect, test, vitest } from 'vitest'
import { AddTransactionController } from './add-transaction-controller'

describe('AddTransactionController', () => {
  function makeSut() {
    const addTransactionUseCaseSpy = new AddTransactionSpy()
    const validationSpy = new ValidationSpy()
    const sut = new AddTransactionController(
      addTransactionUseCaseSpy,
      validationSpy
    )
    return {
      sut,
      addTransactionUseCaseSpy,
      validationSpy,
    }
  }
  describe('handle()', () => {
    test('should call validation with correct params', async () => {
      const { sut, validationSpy } = makeSut()
      const request = mockAddTransaction()
      await sut.handle(request)
      expect(validationSpy.input).toEqual(request)
    })

    test('should return badRequest if validation returns an error', async () => {
      const { sut, validationSpy } = makeSut()
      const error = new Error('any_error')
      validationSpy.error = error
      const response = await sut.handle(mockAddTransaction())
      expect(response).toEqual(badRequest(error))
    })

    test('should return serverError if validation throws', async () => {
      const { sut, validationSpy } = makeSut()
      vitest.spyOn(validationSpy, 'validate').mockImplementationOnce(() => {
        throw new Error('any_error')
      })
      const response = await sut.handle(mockAddTransaction())
      expect(response).toEqual(serverError(new Error('any_error')))
    })
    test('should  call addTransactionUseCase with correct params', async () => {
      const { sut, addTransactionUseCaseSpy } = makeSut()
      const request = mockAddTransaction()
      await sut.handle(request)
      expect(addTransactionUseCaseSpy.addParams).toEqual(request)
    })

    test('should return ok with addTransactionUseCase result', async () => {
      const { sut, addTransactionUseCaseSpy } = makeSut()
      const response = await sut.handle(mockAddTransaction())
      expect(response).toEqual(ok(addTransactionUseCaseSpy.addResult))
    })

    describe('should return serverError if addTransactionUseCase throws', () => {
      test('should return serverError if addTransactionUseCase throws', async () => {
        const { sut, addTransactionUseCaseSpy } = makeSut()
        const mockedError = new Error('mocked_error')
        vitest
          .spyOn(addTransactionUseCaseSpy, 'add')
          .mockRejectedValueOnce(mockedError)
        const response = await sut.handle(mockAddTransaction())
        expect(response).toEqual(serverError(mockedError))
      })
    })
  })
})
