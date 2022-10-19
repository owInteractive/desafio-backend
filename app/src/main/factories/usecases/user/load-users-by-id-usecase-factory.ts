import { DbLoadUsersById } from '@/data/usecases/users'
import { LoadUsersById } from '@/domain/usecases/users'
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySqlRepository/users-mysql-repository'

export function makeDbLoadUsersById(): LoadUsersById {
  return new DbLoadUsersById(new UsersMySqlReposiory())
}
