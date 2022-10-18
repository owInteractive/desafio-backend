import { DeleteUserRepositorySpy, LoadUsersByIdRepositorySpy } from '@/data/test/mock-users'
import { NotFoundError } from '@/presentation/errors'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { DbDeleteUser } from './db-delete-user'

describe('DbDeleteUser', () => {
  function makeSut() {
    const deleteUserRepositorySpy = new DeleteUserRepositorySpy()
    const loadUsersByIdRepositorySpy = new LoadUsersByIdRepositorySpy()
    const sut = new DbDeleteUser(deleteUserRepositorySpy, loadUsersByIdRepositorySpy)
    return { sut, deleteUserRepositorySpy, loadUsersByIdRepositorySpy }
  }
  describe('delete()', () => {
    test('should call deleteUserRepository with correct params', async () => {
      const { sut, deleteUserRepositorySpy } = makeSut()
      const userId = faker.datatype.number()
      await sut.delete({ userId })
      expect(deleteUserRepositorySpy.deleteParams).toEqual({ userId })
    })

    test('should throw if deleteUserRepository throws', async () => {
      const { sut, deleteUserRepositorySpy } = makeSut()
      const mockedError = new Error('mocked error')
      vitest.spyOn(deleteUserRepositorySpy, 'delete').mockRejectedValueOnce(mockedError)
      const userId = faker.datatype.number()
      const promise = sut.delete({ userId })
      await expect(promise).rejects.toThrow(mockedError)
    });

    test('should call LoadUsersByIdRepository with correct values', async () => {
      const { sut, loadUsersByIdRepositorySpy } = makeSut()
      const userId = faker.datatype.number()
      await sut.delete({ userId })
      expect(loadUsersByIdRepositorySpy.loadByIdParams).toEqual({ userId })
    });

    test('should throw if LoadUsersByIdRepository throws', async () => {
      const { sut, loadUsersByIdRepositorySpy } = makeSut()
      const mockedError = new Error('mocked error')
      vitest.spyOn(loadUsersByIdRepositorySpy, 'loadById').mockRejectedValueOnce(mockedError)
      const userId = faker.datatype.number()
      const promise = sut.delete({ userId })
      await expect(promise).rejects.toThrow(mockedError)
    })

    test('should throw NotFoundError if the user does not exists', async () => {
      const { sut, loadUsersByIdRepositorySpy } = makeSut()
      loadUsersByIdRepositorySpy.loadByIdResult = null
      const userId = faker.datatype.number()
      const promise = sut.delete({ userId })
      await expect(promise).rejects.toThrow(new NotFoundError('user'))
    });

    
  })
})
