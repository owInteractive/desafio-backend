import { AddUserRepositorySpy } from '@/data/test/users-mock';
import { mockAddUser } from '@/domain/tests/users-mock';
import { describe, expect, test } from 'vitest';
import { DbAddUser } from './db-add-user';

describe('DbAddUser', () => {
    function makeSut() {
        const addUserRepositorySpy = new AddUserRepositorySpy()
        const sut = new DbAddUser(addUserRepositorySpy);
        return { sut, addUserRepositorySpy };
    }
    test('should call AddUserRepository with correct params', async () => {
        const { sut, addUserRepositorySpy } = makeSut()
        const addUser = mockAddUser()
        await sut.add(addUser)
        expect(addUserRepositorySpy.addParams).toEqual(addUser)
    });
    test('should return a valid User on success', async () => {
        const { sut, addUserRepositorySpy } = makeSut()
        const user = await sut.add(mockAddUser())
        expect(user).toEqual(addUserRepositorySpy.addResult)
    });
});