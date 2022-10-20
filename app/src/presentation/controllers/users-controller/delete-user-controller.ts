import { DeleteUser } from "@/domain/usecases/users";
import { noContent, serverError } from "@/presentation/helpers/http-helper";
import { Controller, HttpResponse } from "@/presentation/protocols";

export class DeleteUserController implements Controller {
  constructor(
    private readonly deleteUserUseCase: DeleteUser,
  ) {}

  async handle(request: DeleteUserController.Request): Promise<DeleteUserController.Response> {
   try {
    await this.deleteUserUseCase.delete({
      userId: request.id,
    })
    return noContent()
   } catch (error) {
    console.error('ERRO AO APAGAR USUÁRIO', error);
    
    return serverError(error)
   }
  }
}

export namespace DeleteUserController {
  export type Request = {
    id: number | string;
  };

  export type Response = HttpResponse
}