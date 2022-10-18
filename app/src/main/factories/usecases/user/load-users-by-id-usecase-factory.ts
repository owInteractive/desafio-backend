import { DbLoadUsersById } from '@/data/usecases/users'
import { LoadUsersById } from '@/domain/usecases/users'
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySQLRepository/users-mysql-repository'

export function makeDbLoadUsersById(): LoadUsersById {
  return new DbLoadUsersById(new UsersMySqlReposiory())
}
