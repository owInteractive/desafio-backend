import { DeleteTransactionById } from '@/domain/usecases/transactions'
import { notFound, ok, serverError } from '@/presentation/helpers/http-helper'
import { Controller, HttpResponse } from '@/presentation/protocols'

export class DeleteTransactionByIdController
  implements Controller<DeleteTransactionByIdController.Request>
{
  constructor(
    private readonly deleteTransactionByIdUseCase: DeleteTransactionById
  ) {}

  async handle(
    request: DeleteTransactionByIdController.Request
  ): Promise<DeleteTransactionByIdController.Result> {
   try {
    const isDeleted = await this.deleteTransactionByIdUseCase.deleteById(request)
    if(!isDeleted) {
      return notFound('transaction', `Transaction ${request.id} does not exits`)
    }
    return ok({success: isDeleted})
   } catch (error) {
    return serverError(error)
   }
  }
}

export namespace DeleteTransactionByIdController {
  export type Request = DeleteTransactionById.Params

  export type Result = HttpResponse<DeleteTransactionById.Result>
}
