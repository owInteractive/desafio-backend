import { LoadUsersByIdSpy } from '@/domain/tests/users-mock'
import { MissingParamError } from '@/presentation/errors/missing-param-error'
import { badRequest, notFound, ok, serverError } from '@/presentation/helpers/http-helper'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { LoadUsersByIdController } from './load-user-by-id-controller'

describe('LoadUserByIdControler', () => {
  function makeSut() {
    const loadUserByIdSpy = new LoadUsersByIdSpy()
    const sut = new LoadUsersByIdController(loadUserByIdSpy)

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

    test('should return 400 if userId was not provided', async () => {
      const { sut } = makeSut()
      const request = {
        userId: null,
      }
      const response = await sut.handle(request)
      expect(response).toEqual(badRequest(new MissingParamError('userId')))
    });

    test('should return 404 if loadUserByIdUseCase returns null', async () => {
      const { sut,loadUserByIdSpy } = makeSut()
      loadUserByIdSpy.loadByIdResult = null
      const request = {
        userId: faker.datatype.number(),
      }
      const response = await sut.handle(request)
      expect(response).toEqual(notFound('user'))
    });

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
