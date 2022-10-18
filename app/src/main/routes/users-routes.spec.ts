import { mockAddUser } from '@/domain/tests/users-mock';
import UsersSequelize from '@/infra/database/sequelize/models/Users';
import { migrate, truncate } from '@/infra/database/sequelize/__tests__/utils';
import request from 'supertest'
import { beforeAll, beforeEach, describe, expect, test } from 'vitest'
import app from '../config/app'

describe('Users Routes', () => {
    describe('POST /users', () => {
        beforeAll(async () => {
            await migrate()
        })

        beforeEach(async () => {
            await truncate()
        })
        test('should return 200 with a valid user', async () => {
            const body = mockAddUser();
            
            const res = await request(app)
                .post('/users')
                .send(body)
                .expect(200)

            expect(res.body.name).toBe(body.name)
            expect(res.body.email).toBe(body.email)
            expect(res.body.id).toBeTruthy()
        });
    });

    describe('GET /users', () => {
        test('should return 200 with valid users in descending order', async () => {
            
            const [userOne, userTwo] = await UsersSequelize.bulkCreate([mockAddUser(),mockAddUser()])
            
            const res = await request(app)
                .get('/users')
                .expect(200)
            
            expect(res.body[0].id).toBe(userOne.getDataValue('id'))
            expect(res.body[1].id).toBe(userTwo.getDataValue('id'))
        });
    });
});