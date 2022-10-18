import { DbDeleteUser } from '@/data/usecases/users'
import { DeleteUser } from '@/domain/usecases/users'
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySQLRepository/users-mysql-repository'

export function makeDbDeleteUser(): DeleteUser {
  return new DbDeleteUser(new UsersMySqlReposiory(), new UsersMySqlReposiory())
}
