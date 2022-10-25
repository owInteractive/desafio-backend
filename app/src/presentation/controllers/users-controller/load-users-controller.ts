import { User } from '@/domain/models';
import { Controller, HttpResponse } from '@/presentation/protocols';
import { LoadUsers } from '@/domain/usecases/users';
import { ok, serverError } from '@/presentation/helpers/http-helper';
export class LoadUsersController implements Controller {
    constructor(
        private loadUsersUseCase: LoadUsers,
    ) {}
    
    async handle(request?: LoadUsersController.Request): Promise<LoadUsersController.Response> {
       try {
        const users = await this.loadUsersUseCase.load(request);
        return ok(users);
       } catch (error) {
        return serverError(error)
       }
    }
}

export namespace LoadUsersController {
    export type Request = {
        order?: 'asc' | 'desc';
    }
    export type Response = HttpResponse<User[]>
  }
  