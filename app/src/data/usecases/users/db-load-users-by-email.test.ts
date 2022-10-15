import { LoadUsersByEmailRepositorySpy } from '@/data/test/users-mock';
import { faker } from '@faker-js/faker';
import { describe, expect, test, vitest } from 'vitest';
import { DbLoadUsersByEmail } from './db-load-users-by-email';

describe('DbLoadUsersByEmail', () => {
    function makeSut() {
        const loadUsersByEmailRepositorySpy = new LoadUsersByEmailRepositorySpy();
        const sut = new DbLoadUsersByEmail(loadUsersByEmailRepositorySpy);
        return { sut, loadUsersByEmailRepositorySpy };
    }
    describe('loadByEmail()', () => {
        test('should call loadUsersRepository with correct params', async () => {
            const { sut, loadUsersByEmailRepositorySpy } = makeSut();
            const email = faker.internet.email()
            await sut.loadByEmail({email});
            expect(loadUsersByEmailRepositorySpy.loadByEmailParams).toEqual({email});
        });
       
        test('should return a user on success', async () => {
            const { sut, loadUsersByEmailRepositorySpy } = makeSut();
            const user = await sut.loadByEmail({email: faker.internet.email()});
            expect(user).toEqual(loadUsersByEmailRepositorySpy.loadByEmailResult);
        })
    });
});