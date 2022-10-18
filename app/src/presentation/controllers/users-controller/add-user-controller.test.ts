import { describe, expect, test, vitest } from 'vitest'
import { AddUserController } from './add-user-controller'
import {
  AddUserSpy,
  LoadUsersByEmailSpy,
  mockUser,
} from '@/domain/tests/users-mock'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { EmailAlreadyInUseError, MissingParamError } from '@/presentation/errors'
import { ValidationSpy } from '@/validation/test/mock-validation'

describe('AddUserController', () => {

  function makeSut() {
    const addUserUseCaseSpy = new AddUserSpy()
    const loadUsersByEmailUseCaseSpy = new LoadUsersByEmailSpy()
    const validationSpy = new ValidationSpy()
    loadUsersByEmailUseCaseSpy.loadByEmailResult = null
    const sut = new AddUserController(
      addUserUseCaseSpy,
      loadUsersByEmailUseCaseSpy,
      validationSpy
    )

    return {
      sut,
      addUserUseCaseSpy,
      loadUsersByEmailUseCaseSpy,
      validationSpy
    }
  }
  describe('handle()', () => {
    test('should call loadUsersByEmailUseCase with the correct email', async () => {
      const { sut, loadUsersByEmailUseCaseSpy } = makeSut()
      const mockedUser = mockUser()
      await sut.handle(mockedUser)

      expect(loadUsersByEmailUseCaseSpy.loadByEmailParams).toEqual({
        email: mockedUser.email,
      })
    })

    test('should return EmailAlreadyInUseError if already exists an user with this email', async () => {
      const { sut, loadUsersByEmailUseCaseSpy } = makeSut()
      const mockedUser = mockUser()
      loadUsersByEmailUseCaseSpy.loadByEmailResult = mockedUser
      const response = await sut.handle(mockedUser)

      expect(response).toEqual(
        badRequest(new EmailAlreadyInUseError(mockedUser.email))
      )
    })

    test('should return serverError if loadUsersByEmail throws', async () => {
        const { sut, loadUsersByEmailUseCaseSpy } = makeSut()
        const mockedUser = mockUser()
        const mockedError = new Error('some_error')
        vitest.spyOn(loadUsersByEmailUseCaseSpy, 'loadByEmail').mockRejectedValueOnce(mockedError)
        const response = await sut.handle(mockedUser)
        expect(response).toEqual(
          serverError(mockedError)
        )
    });

    test('should call AddUser with correct params', async () => {
        const { sut, addUserUseCaseSpy } = makeSut()
        const mockedUser = mockUser()
        await sut.handle(mockedUser)
    
        expect(addUserUseCaseSpy.addParams).toEqual(mockedUser)
    });

    test('should return ok on success', async () => {
        const { sut, addUserUseCaseSpy } = makeSut()
        const mockedUser = mockUser()
        const response = await sut.handle(mockedUser)
    
        expect(response).toEqual(ok(addUserUseCaseSpy.addResult))
    });

    test('should return serverError if addUserUseCase throws', async () => {
        const { sut, addUserUseCaseSpy } = makeSut()
        const mockedUser = mockUser()
        const mockedError = new Error('some_error')
        vitest.spyOn(addUserUseCaseSpy, 'add').mockRejectedValueOnce(mockedError)
        const response = await sut.handle(mockedUser)
        expect(response).toEqual(
          serverError(mockedError)
        )
    });


  test('Should call Validation with correct value', async () => {
    const { sut, validationSpy } = makeSut()
    const request = mockUser()
    await sut.handle(request)
    expect(validationSpy.input).toEqual(request)
  })

  test('Should return 400 if Validation returns an error', async () => {
    const { sut, validationSpy } = makeSut()
    const errorMock = new MissingParamError('any_field')
    validationSpy.error = errorMock
    const request = mockUser()
    const httpResponse = await sut.handle(request)
    expect(httpResponse).toEqual(badRequest(errorMock))
  })
  })
})
