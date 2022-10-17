import { AddUserRepository } from '@/data/protocols/database/users/add-user-repository';
import { AddUser } from '@/domain/usecases/users';

export class DbAddUser implements AddUser {
    constructor(
        private readonly addUserRepository: AddUserRepository,
    ) {}

    async add(user: AddUser.Params): Promise<AddUser.Result> {
        const newUser = await this.addUserRepository.add(user);
        return newUser
    }
}