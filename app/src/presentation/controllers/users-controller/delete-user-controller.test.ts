import { DeleteUserSpy } from "@/domain/tests/mock-users";
import { NotFoundError } from "@/presentation/errors/not-found-error";
import { noContent, serverError } from "@/presentation/helpers/http-helper";
import { describe, expect, test, vitest } from "vitest";
import { DeleteUserController } from "./delete-user-controller";

describe('DeleteUserController', () => {
  function makeSut() {
    const deleteUserUseCaseSpy = new DeleteUserSpy();
    const sut = new DeleteUserController(deleteUserUseCaseSpy)

    return { sut, deleteUserUseCaseSpy }
  }
  test('should call deleteUserUseCase with correct values', async () => {
    const { sut, deleteUserUseCaseSpy } = makeSut()
    const userId = 1
    await sut.handle({ id: userId })
    expect(deleteUserUseCaseSpy.deleteParams).toEqual({ userId })
  });

  test('should return no content on success', async () => {
    const { sut, deleteUserUseCaseSpy } = makeSut()
    const userId = 1
    const result = await sut.handle({ id: userId })
    expect(result).toEqual(noContent())
  });

  test('should return HttpReponse with the error if DeleteUserUseCase throws', async () => {
    const { sut, deleteUserUseCaseSpy } = makeSut()
    const mockedError = new NotFoundError('user')
    vitest.spyOn(deleteUserUseCaseSpy, 'delete').mockRejectedValueOnce(mockedError)
    const httpResponse = await sut.handle({ id: 1 })
    expect(httpResponse).toEqual(serverError(mockedError))
    expect(httpResponse.statusCode).toBe(404)
  });
});