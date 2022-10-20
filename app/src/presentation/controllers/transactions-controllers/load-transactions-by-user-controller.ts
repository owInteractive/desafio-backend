import { LoadTransactionByUser } from '@/domain/usecases/transactions'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { Controller, HttpResponse, Validation } from '@/presentation/protocols'

export class LoadTransactionByUserController implements Controller {
  constructor(
    private readonly loadTransactionByUserUseCase: LoadTransactionByUser,
    private readonly validation: Validation<LoadTransactionByUserController.Request>
  ) {}
  async handle(
    params: LoadTransactionByUserController.Request
  ): Promise<LoadTransactionByUserController.Response> {
    try {
      const error = this.validation.validate(params)
      if (error) {
        return badRequest(error)
      }

      const result = await this.loadTransactionByUserUseCase.loadByUser(params)
      return ok(result)
    } catch (error) {
      return serverError(error)
    }
  }
}

export namespace LoadTransactionByUserController {
  export type Request = LoadTransactionByUser.Params
  export type Response = HttpResponse<LoadTransactionByUser.Result>
}
