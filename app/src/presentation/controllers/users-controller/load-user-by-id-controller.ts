import { User } from '@/domain/models'
import { LoadUsersById } from '@/domain/usecases/users'
import { MissingParamError } from '@/presentation/errors/missing-param-error'
import { ok, serverError, notFound, badRequest } from '@/presentation/helpers/http-helper'
import { HttpResponse } from '@/presentation/protocols'

export class LoadUsersByIdController {
  constructor(private readonly loadUserByIdUseCase: LoadUsersById) {}

  async handle(
    request: LoadUsersByIdController.Request
  ): Promise<LoadUsersByIdController.Response> {
    try {
      const { id: userId } = request
      if (!userId) {
        return badRequest(new MissingParamError('userId'))
      } 
      const user = await this.loadUserByIdUseCase.loadById({
        userId,
      })

      if (!user) {
        return notFound('user')
      }
      return ok(user)
    } catch (error) {
      console.error(error);
      
      return serverError(error)
    }
  }
}

export namespace LoadUsersByIdController {
  export type Request = {
    id: number
  }
  export type Response = HttpResponse<User>
}
