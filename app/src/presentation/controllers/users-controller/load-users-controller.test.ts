import { LoadUsersSpy } from '@/domain/tests/mock-users';
import {  ok, serverError } from '@/presentation/helpers/http-helper';
import { describe, expect, test, vitest } from 'vitest';
import { LoadUsersController } from './load-users-controller';

describe('LoadUsersController', () => {
    function makeSut() {
        const loadUsersSpy = new LoadUsersSpy();
        const sut = new LoadUsersController(
            loadUsersSpy,
        );

        return {
            sut,
            loadUsersSpy,
        }
    }
    describe('handle()', () => {
        test('should call loadUsersUseCase with correct params', async () => {
            const { sut, loadUsersSpy } = makeSut();

            await sut.handle({
                order: 'asc'
            });

            expect(loadUsersSpy.loadParams).toEqual({
                order: 'asc'
            })
        });

        test('should return 200 with the loadUsersUseCase result', async () => {
            const { sut, loadUsersSpy } = makeSut();

            const res = await sut.handle();

            expect(res).toEqual(ok(
                loadUsersSpy.loadResult
            ))
        });

        test('should return 500 if loadUsersUseCase throws', async () => {
            const { sut, loadUsersSpy } = makeSut();
            const mockedError = new Error('some_error')
            vitest.spyOn(loadUsersSpy, 'load').mockImplementationOnce(() => {
                throw mockedError;
            });

            const res = await sut.handle();

            expect(res).toEqual(
                serverError(mockedError)
            )
        });
    })
});