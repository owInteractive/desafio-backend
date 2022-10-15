import { LoadUsersRepositorySpy } from '@/data/test/users-mock';
import { describe, expect, test, vitest } from 'vitest';
import { DbLoadUsers } from './db-load-users';

describe('DbLoadUsers', () => {
    function makeSut() {
        const loadUsersRepositorySpy = new LoadUsersRepositorySpy();
        const sut = new DbLoadUsers(loadUsersRepositorySpy);
        return { sut, loadUsersRepositorySpy };
    }
    describe('load()', () => {
        test('should call loadUsersRepository with correct params', async () => {
            const { sut, loadUsersRepositorySpy } = makeSut();
            await sut.load({order: 'asc'});
            expect(loadUsersRepositorySpy.loadParams).toEqual({order: 'asc'});
        });
        test('should return a list of users on success', async () => {
            const { sut, loadUsersRepositorySpy } = makeSut();
            const users = await sut.load({order: 'asc'});
            expect(users).toEqual(loadUsersRepositorySpy.loadResult);
        })

        test('should throw if loadUsersRepository throws', async () => {
            const { sut, loadUsersRepositorySpy } = makeSut();
            vitest.spyOn(loadUsersRepositorySpy, 'load').mockImplementationOnce(() => {
                throw new Error();
            });
            await expect(sut.load({order: 'asc'})).rejects.toThrow();
        });
    });
});