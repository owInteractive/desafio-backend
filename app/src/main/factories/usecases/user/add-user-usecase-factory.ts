import { DbAddUser } from '@/data/usecases/users/db-add-user';
import { AddUser } from '@/domain/usecases/users';
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySQLRepository/users-mysql-repository';

export function makeDbAddUser(): AddUser {
    const addUserRepository = new UsersMySqlReposiory();
    return new DbAddUser(addUserRepository);
}