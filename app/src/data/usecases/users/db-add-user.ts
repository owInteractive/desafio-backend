import { AddUserRepository } from '@/data/protocols/database/users/add-user-repository';
import { DateFormatter } from '@/data/protocols/utils';
import { AddUser } from '@/domain/usecases/users';

export class DbAddUser implements AddUser {
    constructor(
        private readonly addUserRepository: AddUserRepository,
        private readonly dateFormatter: DateFormatter
    ) {}

    async add(user: AddUser.Params): Promise<AddUser.Result> {
        user.birthDay = this.dateFormatter.format(user.birthDay)
        const newUser = await this.addUserRepository.add(user);
        return newUser
    }
}