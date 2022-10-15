import { describe, expect, test } from 'vitest'
import { AddUserController } from './add-user-controller';
import { AddUserSpy, LoadUsersByEmailSpy, mockUser } from '@/domain/tests/users.mock';
import { badRequest } from '@/presentation/helpers/http-helper';
import { EmailAlreadyInUseError } from '@/presentation/errors';

describe('AddUserController', () => {
    type SutType = {
        sut: AddUserController
        addUserUseCaseSpy: AddUserSpy
        loadUsersByEmailUseCaseSpy: LoadUsersByEmailSpy
    }
    function makeSut(): SutType {
        const addUserUseCaseSpy = new AddUserSpy()
        const loadUsersByEmailUseCaseSpy = new LoadUsersByEmailSpy()
        const sut = new AddUserController(addUserUseCaseSpy, loadUsersByEmailUseCaseSpy)

        return {
            sut,
            addUserUseCaseSpy,
            loadUsersByEmailUseCaseSpy
        }
    }
    describe('handle()', () => {
        test('should call loadUsersByEmailUseCase with the correct email', async () => {
            const { sut, loadUsersByEmailUseCaseSpy } = makeSut()
            const mockedUser = mockUser()
            await sut.handle(mockedUser)

            expect(loadUsersByEmailUseCaseSpy.loadByEmailParams).toEqual({email:mockedUser.email})
        });

        test('should return EmailAlreadyInUseError if already exists an user with this email', async () => {
            const { sut, loadUsersByEmailUseCaseSpy } = makeSut()
            const mockedUser = mockUser()
            loadUsersByEmailUseCaseSpy.loadByEmailResult = mockedUser
            const response = await sut.handle(mockedUser)

            expect(response).toEqual(badRequest(new EmailAlreadyInUseError(mockedUser.email)))
        });
    });
});