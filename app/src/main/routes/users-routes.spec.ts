import { mockAddUser } from '@/domain/tests/users-mock';
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
});