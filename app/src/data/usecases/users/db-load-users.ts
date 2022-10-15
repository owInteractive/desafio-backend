import { LoadUsersRepository } from '@/data/protocols/database/users/load-user-repository';
import { LoadUsers } from '@/domain/usecases/users';

export class DbLoadUsers implements LoadUsers {
    constructor(
        private readonly loadUsersRepository: LoadUsersRepository,
    ) {}
    async load(params: LoadUsers.Params): Promise<LoadUsers.Result> {
        return this.loadUsersRepository.load(params);
    }
}