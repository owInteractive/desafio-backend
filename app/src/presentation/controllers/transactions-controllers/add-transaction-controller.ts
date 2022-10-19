import { AddTransaction } from '@/domain/usecases/transactions'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { Controller, HttpResponse, Validation } from '@/presentation/protocols'

export class AddTransactionController implements Controller {
  constructor(
    private readonly addTransactionUseCase: AddTransaction,
    private readonly validation: Validation<AddTransactionController.Request>
  ) {}

  async handle(
    request: AddTransactionController.Request
  ): Promise<AddTransactionController.Response> {
    try {
      const error = this.validation.validate(request)
      if (error) {
        return badRequest(error)
      }
      const result = await this.addTransactionUseCase.add(request)
      return ok(result)
    } catch (error) {
      return serverError(error)
    }
  }
}

export namespace AddTransactionController {
  export type Request = AddTransaction.Params

  export type Response = HttpResponse<AddTransaction.Result>
}
