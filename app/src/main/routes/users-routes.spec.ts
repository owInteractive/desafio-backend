import { mockAddUser } from '@/domain/tests/mock-users'
import UsersSequelize from '@/infra/database/sequelize/models/User'
import { migrate, truncate } from '@/infra/database/sequelize/__tests__/utils'
import request from 'supertest'
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest'
import app from '../config/app'
import MockDate from 'mockdate'
import { faker } from '@faker-js/faker'
import TransactionSequelize from '@/infra/database/sequelize/models/Transaction'
import { mockAddTransaction } from '@/domain/tests/mock-transactions'

describe('Users Routes', () => {
  beforeAll(async () => {
    await migrate()
  })

  beforeEach(async () => {
    await truncate()
  })

  afterAll(async () => {
    await truncate()
  })

  async function makeUser() {
    const user = mockAddUser()
    const createdUser = await UsersSequelize.create(user)
    return createdUser.toJSON()
  }
  describe('POST /users', () => {
    test('should return 200 with a valid user', async () => {
      const body = mockAddUser()

      const res = await request(app).post('/users').send(body).expect(200)

      expect(res.body.name).toBe(body.name)
      expect(res.body.email).toBe(body.email)
      expect(res.body.id).toBeTruthy()
    })
  })

  describe('GET /users', () => {
    test('should return 200 with valid users in descending order', async () => {
      const now = new Date()
      const older = new Date(now.getTime() - 1000)

      const [userOne, userTwo] = await UsersSequelize.bulkCreate([
        { ...mockAddUser(), createdAt: now },
        { ...mockAddUser(), createdAt: older },
      ])

      const res = await request(app).get('/users').expect(200)

      expect(res.body[0].id).toBe(userOne.getDataValue('id'))
      expect(res.body[1].id).toBe(userTwo.getDataValue('id'))
    })

    test('should return 200 with valid users in asccending order', async () => {
      const now = new Date()
      const older = new Date(now.getTime() - 1000)

      const [userOne, userTwo] = await UsersSequelize.bulkCreate([
        { ...mockAddUser(), createdAt: now },
        { ...mockAddUser(), createdAt: older },
      ])

      const res = await request(app)
        .get('/users')
        .query({ order: 'asc' })
        .expect(200)

      expect(res.body[0].id).toBe(userTwo.getDataValue('id'))
      expect(res.body[1].id).toBe(userOne.getDataValue('id'))
    })
  })

  describe('GET /users/{id}', () => {
    test('should return 404 if the user does not exits', async () => {
      await request(app)
        .get('/users/1')
        .expect(404)
        .expect({ error: 'Not Found: user' })
    })

    test('should return 200 with the user', async () => {
      const user = await UsersSequelize.create(mockAddUser())

      const res = await request(app)
        .get(`/users/${user.getDataValue('id')}`)
        .expect(200)

      expect(res.body.id).toBe(user.getDataValue('id'))
    })
  })

  describe('DELETE /users/{id}', () => {
    test('should return 404 if the user does not exits', async () => {
      await request(app)
        .delete('/users/1')
        .expect(404)
        .expect({ error: 'Not Found: user' })
    })

    test('should delete an user according to the id', async () => {
      const user = await UsersSequelize.create(mockAddUser())
      const id = user.getDataValue('id')
      const usersExists = await UsersSequelize.findOne({ where: { id } })
      expect(usersExists).toBeTruthy()
      await request(app).delete(`/users/${id}`).expect(204)
      const usersAfterDelete = await UsersSequelize.findOne({ where: { id } })
      expect(usersAfterDelete).toBeFalsy()
    })
  })

  describe('POST /users/{id}/transactions', () => {
    test('should create an transaction from an user to other', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())

      const id = userFrom.getDataValue('id')
      const body = {
        amount: faker.datatype.number(),
        description: faker.lorem.sentence(),
        to: userTo.getDataValue('id'),
        type: 'credit',
      }
      const res = await request(app)
        .post(`/users/${id}/transactions`)
        .send(body)

      expect(res.body.id).toBeTruthy()
      const transaction = await TransactionSequelize.findOne({
        where: { id: res.body.id },
      })
      expect(transaction).toBeTruthy()
    })

    test('should return an transaction from an user to other', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())

      const id = userFrom.getDataValue('id')
      const body = {
        amount: faker.datatype.number(),
        description: faker.lorem.sentence(),
        to: userTo.getDataValue('id'),
        type: 'credit',
      }
      const res = await request(app)
        .post(`/users/${id}/transactions`)
        .send(body)

      expect(res.statusCode).toBe(200)
      expect(res.body.amount).toBe(body.amount)
      expect(res.body.description).toBe(body.description)
      expect(res.body.to.id).toBe(body.to)
      expect(res.body.type).toBe(body.type)
      expect(res.body.from.id).toBe(id)
    })
  })

  describe('GET /users/{id}/transactions', () => {
    test('should return the users transactions paginated', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())
      const idFrom = userFrom.getDataValue('id')
      const idTo = userTo.getDataValue('id')
      await TransactionSequelize.bulkCreate(
        [
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
        ].map(transaction => ({ ...transaction, from: idFrom, to: idTo }))
      )

      const res = await request(app)
        .get(`/users/${idFrom}/transactions`)
        .query({ page: 1, perPage: 3, userId: idTo })

      expect(res.body.pagination).toEqual({
        page: 1,
        perPage: 3,
        total: 6,
        totalPages: 2,
      })
    })

    test('should return the users transactions according to the page', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())
      const idFrom = userFrom.getDataValue('id')
      const idTo = userTo.getDataValue('id')
      const transactions = await TransactionSequelize.bulkCreate(
        [
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
        ].map(transaction => ({ ...transaction, from: idFrom, to: idTo }))
      )

      const res = await request(app)
        .get(`/users/${idFrom}/transactions`)
        .query({ page: 1, perPage: 3, userId: idTo })

      expect(res.body.data[0].id).toBe(transactions[0].getDataValue('id'))
    })

    test('should return the users transactions according to the page', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())
      const idFrom = userFrom.getDataValue('id')
      const idTo = userTo.getDataValue('id')
      const transactions = await TransactionSequelize.bulkCreate(
        [
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
          mockAddTransaction(),
        ].map(transaction => ({ ...transaction, from: idFrom, to: idTo }))
      )

      const res = await request(app)
        .get(`/users/${idFrom}/transactions`)
        .query({ page: 2, perPage: 3, userId: idTo })

      expect(res.body.data[0].id).toBe(transactions[3].getDataValue('id'))
    })
  })
})
