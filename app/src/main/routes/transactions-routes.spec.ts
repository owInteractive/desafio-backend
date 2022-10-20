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

describe('Transactions Routes', () => {
  beforeAll(async () => {
    await migrate()
  })

  beforeEach(async () => {
    await truncate()
  })

  afterAll(async () => {
    await truncate()
  })

  describe('POST /transactions', () => {
    test('should create an transaction', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())

      const id = userFrom.getDataValue('id')
      const body = {
        amount: faker.datatype.number(),
        description: faker.lorem.sentence(),
        from: id,
        to: userTo.getDataValue('id'),
        type: 'credit',
      }
      const res = await request(app).post(`/transactions`).send(body)

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
        from: id,
        to: userTo.getDataValue('id'),
        type: 'credit',
      }
      const res = await request(app).post(`/transactions`).send(body)

      expect(res.statusCode).toBe(200)
      expect(res.body.amount).toBe(body.amount)
      expect(res.body.description).toBe(body.description)
      expect(res.body.to.id).toBe(body.to)
      expect(res.body.type).toBe(body.type)
      expect(res.body.from.id).toBe(id)
    })
  })

  describe('GET /transactions', () => {
    test('should return the users transactions paginated according to the userId', async () => {
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
        .get(`/transactions`)
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

  describe('DELETE /transactions/{id}', () => {
    test('should return 404 if an unexisting user is provided', async () => {
      const res = await request(app).delete('/transactions/1')

      expect(res.statusCode).toBe(404)
    })

    test('should delete the user provided', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())
      const idFrom = userFrom.getDataValue('id')
      const idTo = userTo.getDataValue('id')
      const transaction = await TransactionSequelize.create({
        ...mockAddTransaction(),
        from: idFrom,
        to: idTo,
      })

      await request(app).delete(
        `/transactions/${transaction.getDataValue('id')}`
      )
      const transactionExits = await TransactionSequelize.findOne({
        where: { id: transaction.getDataValue('id') },
      })
      expect(transactionExits).toBeFalsy()
    })

    test('should delete the user provided', async () => {
      const userFrom = await UsersSequelize.create(mockAddUser())
      const userTo = await UsersSequelize.create(mockAddUser())
      const idFrom = userFrom.getDataValue('id')
      const idTo = userTo.getDataValue('id')
      const transaction = await TransactionSequelize.create({
        ...mockAddTransaction(),
        from: idFrom,
        to: idTo,
      })

      const res = await request(app).delete(
        `/transactions/${transaction.getDataValue('id')}`
      )

      expect(res.statusCode).toBe(200)
    })
  })
})
