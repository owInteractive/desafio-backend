import { mockAddUser } from '@/domain/tests/users-mock'
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest'
import { UsersMySqlReposiory } from './users-mysql-repository'
import { migrate, truncate } from '../__tests__/utils'
import MockDate from 'mockdate'
import UsersSequelize from '../models/Users'
import { User } from '@/domain/models'

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
      expect(user.birthDay).toEqual(mockedUser.birthDay)
      expect(user.role).toEqual(mockedUser.role)
      expect(user.createdAt).toEqual(new Date())
    })

    test('should return an user without role on success', async () => {
      const { sut } = makeSut()
      const mockedUser = mockAddUser()
      delete  mockedUser.role
      const user = await sut.add(mockedUser)
      expect(user.name).toEqual(mockedUser.name)
      expect(user.email).toEqual(mockedUser.email)
      expect(user.password).toEqual(mockedUser.password)
      expect(user.birthDay).toEqual(mockedUser.birthDay)
      expect(user.createdAt).toEqual(new Date())
    })

  })

  describe('load()', () => {
    test('should load all Users', async () => {
      const { sut } = makeSut()
      const mockedUser = mockAddUser()
      const mockedOtherUser = mockAddUser()

      await UsersSequelize.create(mockedUser)
      await UsersSequelize.create(mockedOtherUser)

      const users = await sut.load()
      expect(users.length).toBe(2)
    })

    test('should load all Users in in descending order if called with order desc', async () => {
      const { sut } = makeSut()
      const mockMostRecentUser = mockAddUser()
      mockMostRecentUser.createdAt = new Date('2021-01-01 13:00:00')

      const mockOldestUser = mockAddUser()
      mockOldestUser.createdAt = new Date('2021-01-01 12:00:00')

      const mostRecentUser = (await UsersSequelize.create(
        mockMostRecentUser
      )) as any
      const oldestUser = (await UsersSequelize.create(mockOldestUser)) as any
      const users = await sut.load({ order: 'desc' })
      expect(users[0].id).toEqual(mostRecentUser.id)
      expect(users[1].id).toEqual(oldestUser.id)
    })

    test('should load all Users in in ascending order if called with order asc', async () => {
      const { sut } = makeSut()
      const mockMostRecentUser = mockAddUser()
      mockMostRecentUser.createdAt = new Date('2021-01-01 13:00:00')

      const mockOldestUser = mockAddUser()
      mockOldestUser.createdAt = new Date('2021-01-01 12:00:00')

      const mostRecentUser = (await UsersSequelize.create(
        mockMostRecentUser
      )) as any
      const oldestUser = (await UsersSequelize.create(mockOldestUser)) as any
      const users = await sut.load({ order: 'asc' })
      expect(users[0].id).toEqual(oldestUser.id)
      expect(users[1].id).toEqual(mostRecentUser.id)
    })
  })

  describe('loadByEmail()', () => {
    test('should load the correct User according to the email', async () => {
      const { sut } = makeSut()
      const mockedUser = mockAddUser()
      const mockedOtherUser = mockAddUser()

      await UsersSequelize.create(mockedUser)
      await UsersSequelize.create(mockedOtherUser)

      const user = await sut.loadByEmail({
        email: mockedUser.email,
      })
      expect(user.name).toEqual(mockedUser.name)
      expect(user.email).toEqual(mockedUser.email)
    })

    test('should return null if the User does not exists', async () => {
      const { sut } = makeSut()
      const user = await sut.loadByEmail({
        email: 'some_email@mail.com',
      })
      expect(user).toBeNull()
    })
  })

  describe('loadById()', () => {
    test('should load the correct User according to the id', async () => {
      const { sut } = makeSut()
      const mockedUser = mockAddUser()
      const mockedOtherUser = mockAddUser()

      const { id } = await UsersSequelize.create(mockedUser) as any
      await UsersSequelize.create(mockedOtherUser)

      const user = await sut.loadById({
        userId: id
      })
      expect(user.id).toBe(id)
      expect(user.name).toEqual(mockedUser.name)
      expect(user.email).toEqual(mockedUser.email)
    })

    test('should return null if the User does not exists', async () => {
      const { sut } = makeSut()
      const user = await sut.loadById({
        userId: 1
      })
      expect(user).toBeNull()
    })
  })

  describe('delete()', () => {
    test('should delete the correct User according to the id', async () => {
      const { sut } = makeSut()
      const mockedUser = mockAddUser()
      const mockedOtherUser = mockAddUser()

      const { id } = await UsersSequelize.create(mockedUser) as any
      await UsersSequelize.create(mockedOtherUser)

      await sut.delete({
        userId: id
      })
      const user = await UsersSequelize.findOne({
        where: {
          id
        }
      })
      expect(user).toBeNull()
    })
  });
})
