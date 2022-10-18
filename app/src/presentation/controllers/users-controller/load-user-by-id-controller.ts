import { User } from '@/domain/models'
import { LoadUsersById } from '@/domain/usecases/users'
import { ok, serverError } from '@/presentation/helpers/http-helper'
import { HttpResponse } from '@/presentation/protocols'

export class LoadUserByIdController {
  constructor(private readonly loadUserByIdUseCase: LoadUsersById) {}

  async handle(
    request: LoadUserByIdController.Request
  ): Promise<LoadUserByIdController.Response> {
    try {
      const { userId } = request
      const user = await this.loadUserByIdUseCase.loadById({
        userId,
      })

      return ok(user)
    } catch (error) {
      return serverError(error)
    }
  }
}

export namespace LoadUserByIdController {
  export type Request = {
    userId: number
  }
  export type Response = HttpResponse<User>
}
