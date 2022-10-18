import { LoadUsersByIdSpy } from '@/domain/tests/users-mock'
import { ok, serverError } from '@/presentation/helpers/http-helper'
import { describe, expect, test, vitest } from 'vitest'
import { LoadUserByIdController } from './load-user-by-id-controller'

describe('LoadUserByIdControler', () => {
  function makeSut() {
    const loadUserByIdSpy = new LoadUsersByIdSpy()
    const sut = new LoadUserByIdController(loadUserByIdSpy)

    return {
      sut,
      loadUserByIdSpy,
    }
  }
  describe('handle()', () => {
    test('should call loadUserByIdUseCase with correct user id', async () => {
      const { sut, loadUserByIdSpy } = makeSut()
      const request = {
        userId: 1,
      }
      await sut.handle(request)
      expect(loadUserByIdSpy.loadByIdParams).toEqual(request)
    })

    test('should return 500 if loadUserByIdUseCase throws', async () => {
      const { sut, loadUserByIdSpy } = makeSut()
      const mockedError = new Error('some_error')
      vitest
        .spyOn(loadUserByIdSpy, 'loadById')
        .mockRejectedValueOnce(mockedError)
      const request = {
        userId: 1,
      }
      const response = await sut.handle(request)
      expect(response).toEqual(serverError(mockedError))
    })

    test('should return 200 if loadUserByIdUseCase succeeds', async () => {
      const { sut, loadUserByIdSpy } = makeSut()
      const request = {
        userId: 1,
      }
      const response = await sut.handle(request)
      expect(response).toEqual(ok(loadUserByIdSpy.loadByIdResult))
    })
  })
})
