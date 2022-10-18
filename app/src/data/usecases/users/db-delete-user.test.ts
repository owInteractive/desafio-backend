import { DeleteUserRepositorySpy } from '@/data/test/users-mock'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { DbDeleteUser } from './db-delete-user'

describe('DbDeleteUser', () => {
  function makeSut() {
    const deleteUserRepositorySpy = new DeleteUserRepositorySpy()
    const sut = new DbDeleteUser(deleteUserRepositorySpy)
    return { sut, deleteUserRepositorySpy }
  }
  describe('loadById()', () => {
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
  })
})
