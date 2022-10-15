import { describe, expect, test, vitest } from 'vitest'
import { AddUserController } from './add-user-controller'
import {
  AddUserSpy,
  LoadUsersByEmailSpy,
  mockUser,
} from '@/domain/tests/users-mock'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { EmailAlreadyInUseError } from '@/presentation/errors'

describe('AddUserController', () => {
  type SutType = {
    sut: AddUserController
    addUserUseCaseSpy: AddUserSpy
    loadUsersByEmailUseCaseSpy: LoadUsersByEmailSpy
  }
  function makeSut(): SutType {
    const addUserUseCaseSpy = new AddUserSpy()
    const loadUsersByEmailUseCaseSpy = new LoadUsersByEmailSpy()
    loadUsersByEmailUseCaseSpy.loadByEmailResult = null
    const sut = new AddUserController(
      addUserUseCaseSpy,
      loadUsersByEmailUseCaseSpy
    )

    return {
      sut,
      addUserUseCaseSpy,
      loadUsersByEmailUseCaseSpy,
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

    test('should return 200 on success', async () => {
        const { sut, addUserUseCaseSpy } = makeSut()
        const mockedUser = mockUser()
        const response = await sut.handle(mockedUser)
    
        expect(response).toEqual(ok(addUserUseCaseSpy.addResult))
    });
  })
})
