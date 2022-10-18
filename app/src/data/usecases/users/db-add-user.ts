import { AddUserRepository } from '@/data/protocols/database/users/add-user-repository';
import { AddUser } from '@/domain/usecases/users';

export class DbAddUser implements AddUser {
    constructor(
        private readonly addUserRepository: AddUserRepository,
    ) {}

    async add(params: AddUser.Params): Promise<AddUser.Result> {
        const user: AddUser.Params = {
            ...params,
            birthDay: new Date(params.birthDay)
        }
        const newUser = await this.addUserRepository.add(user);
        return newUser
    }
}