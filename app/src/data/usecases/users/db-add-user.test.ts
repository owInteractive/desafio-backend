import { DateFormatterSpy } from '@/data/test/mock-date-formatter';
import { AddUserRepositorySpy } from '@/data/test/mock-users';
import { mockAddUser } from '@/domain/tests/users-mock';
import { afterAll, beforeAll, beforeEach, describe, expect, test } from 'vitest';
import { DbAddUser } from './db-add-user';
import MockDate from 'mockdate'

describe('DbAddUser', () => {
    beforeAll(() => {
        MockDate.set(new Date())
    })

    afterAll(() => {
        MockDate.reset()
    })
    function makeSut() {
        const addUserRepositorySpy = new AddUserRepositorySpy()
        const dateFormatterSpy = new DateFormatterSpy()
        const sut = new DbAddUser(addUserRepositorySpy, dateFormatterSpy);
        return { sut, addUserRepositorySpy, dateFormatterSpy };
    }
    test('should call AddUserRepository with correct params', async () => {
        const { sut, addUserRepositorySpy } = makeSut()
        const addUser = mockAddUser()
        await sut.add(addUser)
        expect(addUserRepositorySpy.addParams).toEqual(addUser)
    });

    test('should call dateFormatter with correct user birthDay', async () => {
        const { sut, dateFormatterSpy} = makeSut()
        const addUser = mockAddUser()
        await sut.add({...addUser})
        expect(dateFormatterSpy.inputDate).toBe(addUser.birthDay)
    });

    test('should format the user birthDay using dateFormatter', async () => {
        const { sut, dateFormatterSpy, addUserRepositorySpy} = makeSut()
        const addUser = mockAddUser()
        const user = await sut.add({...addUser})
        expect(addUserRepositorySpy.addParams.birthDay).toBe(dateFormatterSpy.finalDate)
    });

    test('should return a valid User on success', async () => {
        const { sut, addUserRepositorySpy } = makeSut()
        const user = await sut.add(mockAddUser())
        expect(user).toEqual(addUserRepositorySpy.addResult)
    });
});