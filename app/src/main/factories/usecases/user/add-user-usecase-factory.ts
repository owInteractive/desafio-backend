import { DbAddUser } from '@/data/usecases/users/db-add-user';
import { AddUser } from '@/domain/usecases/users';
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySqlRepository/users-mysql-repository';
import { MomentDateFormatter } from '@/infra/utils';

export function makeDbAddUser(): AddUser {
    const addUserRepository = new UsersMySqlReposiory();
    const dateFormat = 'YYYY-MM-DD'
    const momentDateFormatter = new MomentDateFormatter(dateFormat)
    return new DbAddUser(addUserRepository, momentDateFormatter);
}