import { LoadUsersByIdRepositorySpy } from '@/data/test/mock-users'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { DbLoadUsersById } from './db-load-users-by-id'

describe('DbLoadUsersById', () => {
  function makeSut() {
    const loadUsersByIdRepositorySpy = new LoadUsersByIdRepositorySpy()
    const sut = new DbLoadUsersById(loadUsersByIdRepositorySpy)
    return { sut, loadUsersByIdRepositorySpy }
  }
  describe('loadById()', () => {
    test('should call loadUsersByIdRepository with correct params', async () => {
      const { sut, loadUsersByIdRepositorySpy } = makeSut()
      const userId = faker.datatype.number()
      await sut.loadById({ userId })
      expect(loadUsersByIdRepositorySpy.loadByIdParams[0]).toEqual({ userId })
    })

    test('should return a user on success', async () => {
      const { sut, loadUsersByIdRepositorySpy } = makeSut()
      const user = await sut.loadById({ userId: faker.datatype.number() })
      expect(user).toEqual(loadUsersByIdRepositorySpy.loadByIdResult)
    })

    test('should return null if any user was found', async () => {
      const { sut, loadUsersByIdRepositorySpy } = makeSut()
      loadUsersByIdRepositorySpy.loadByIdResult = null
      const user = await sut.loadById({ userId: faker.datatype.number() })
      expect(user).toBeNull()
    })

    test('should throw if loadUsersByIdRepository throws', async () => {
        const { sut, loadUsersByIdRepositorySpy } = makeSut()
        const mockedError = new Error('mocked error')
        vitest.spyOn(loadUsersByIdRepositorySpy, 'loadById').mockRejectedValueOnce(mockedError)
        const promise = sut.loadById({ userId: faker.datatype.number() })
        await expect(promise).rejects.toThrow(mockedError)
    })
  })
})
