import { User } from '@/domain/models'
import { AddUser, LoadUsersByEmail } from '@/domain/usecases/users'
import { EmailAlreadyInUseError } from '@/presentation/errors'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { Controller, HttpResponse } from '@/presentation/protocols'

export class AddUserController implements Controller {
  constructor(
    private readonly addUserUseCase: AddUser,
    private readonly loadUsersByEmailUseCase: LoadUsersByEmail
  ) {}

  async handle(
    request: AddUserController.Request
  ): Promise<AddUserController.Response> {
    try {
      const emaiInUse = await this.loadUsersByEmailUseCase.loadByEmail({
        email: request.email,
      })

      if (emaiInUse) {
        return badRequest(new EmailAlreadyInUseError(request.email))
      }

      const result = await this.addUserUseCase.add(request)

      return ok(result)
    } catch (error) {
      return serverError(error)
    }
  }
}

export namespace AddUserController {
  export type Request = Omit<User, 'id'>
  export type Response = HttpResponse<User>
}
