import { mockAddUser } from '@/domain/tests/users-mock'
import UsersSequelize from '@/infra/database/sequelize/models/Users'
import { migrate, truncate } from '@/infra/database/sequelize/__tests__/utils'
import request from 'supertest'
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest'
import app from '../config/app'

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
        .expect({ error: 'user not found' })
    })

    test('should return 200 with the user', async () => {
      const user = await UsersSequelize.create(mockAddUser())

      const res = await request(app)
        .get(`/users/${user.getDataValue('id')}`)
        .expect(200)

      expect(res.body.id).toBe(user.getDataValue('id'))
    })
  })
})
