import { LoadTransactionByUserSpy } from "@/domain/tests/mock-transactions";
import { badRequest, ok, serverError } from "@/presentation/helpers/http-helper";
import { ValidationSpy } from "@/validation/test/mock-validation";
import { faker } from "@faker-js/faker";
import { describe, expect, test, vitest } from "vitest";
import { LoadTransactionByUserController } from "./load-transactions-by-user-controller";

describe('LoadTransactionByUserController', () => {
  function makeSut() {
    const loadTransactionByUserSpy = new LoadTransactionByUserSpy()
    const validationSpy = new ValidationSpy();
    const sut = new LoadTransactionByUserController(
      loadTransactionByUserSpy,
      validationSpy
    )

    return {
      sut,
      loadTransactionByUserSpy,
      validationSpy
    }
  }
  describe('handle()', () => {
    test('should call validation with correct params', async () => {
      const { sut, validationSpy } = makeSut()
      const request = {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        userId: faker.datatype.number()
      }

      await sut.handle(request)
      expect(validationSpy.input).toEqual(request)
    })

    test('should return badRequest if validation returns an error', async () => {
      const { sut, validationSpy } = makeSut()
      const error = new Error('any_error')
      validationSpy.error = error
      const request = {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        userId: faker.datatype.number()
      }

      const response = await sut.handle(request)
      expect (response).toEqual(badRequest(error))
    })

    test('should return serverError if validation throws', async () => {
      const { sut, validationSpy } = makeSut()
      vitest.spyOn(validationSpy, 'validate').mockImplementationOnce(() => {
        throw new Error('any_error')
      })
      const request = {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        userId: faker.datatype.number()
      }

      const response = await sut.handle(request)
      expect(response).toEqual(serverError(new Error('any_error')))
    })

    test('should call loadTransactionByUserUseCase with correct params', async () => {
      const { sut, loadTransactionByUserSpy } = makeSut()
      const request = {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        userId: faker.datatype.number()
      }

      await sut.handle(request)
      expect(loadTransactionByUserSpy.loadByUserParams).toEqual(request)
    });

    test('should return ok with loadTransactionByUserUseCase result', async () => {
      const { sut, loadTransactionByUserSpy } = makeSut()
      const request = {
        page: faker.datatype.number(),
        perPage: faker.datatype.number(),
        userId: faker.datatype.number()
      }

      const result = await sut.handle(request)
      expect(result).toEqual(ok(loadTransactionByUserSpy.loadByUserResult))
    });
  });
});