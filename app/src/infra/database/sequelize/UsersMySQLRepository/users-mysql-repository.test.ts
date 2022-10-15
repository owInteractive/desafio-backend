import { mockAddUser } from '@/domain/tests/users-mock'
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest'
import { UsersMySqlReposiory } from './users-mysql-repository'
import { migrate, truncate } from '../__tests__/utils'
import MockDate from 'mockdate'

describe('UsersMySqlReposiory', () => {
  function makeSut() {
    const sut = new UsersMySqlReposiory()
    return { sut }
  }

  beforeAll(async () => {
    MockDate.set(new Date())
    await migrate()
  })

  afterAll(async () => {
    await truncate()
    MockDate.reset()
  })

  beforeEach(async () => {
    await truncate()
    await migrate()
  })
  describe('add()', () => {
    test('should return an user on success', async () => {
      const { sut } = makeSut()
      const mockedUser = mockAddUser()
      const user = await sut.add(mockedUser)
      expect(user.name).toEqual(mockedUser.name)
      expect(user.email).toEqual(mockedUser.email)
      expect(user.password).toEqual(mockedUser.password)
      expect(user.brithDay).toEqual(mockedUser.brithDay)
      expect(user.role).toEqual(mockedUser.role)
      expect(user.createdAt).toEqual(new Date())
    })
  })
})
