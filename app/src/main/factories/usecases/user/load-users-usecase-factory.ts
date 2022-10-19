import { DbLoadUsers } from '@/data/usecases/users/db-load-users'
import { LoadUsers } from '@/domain/usecases/users'
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySqlRepository/users-mysql-repository'

export function makeDbLoadUsers(): LoadUsers {
  return new DbLoadUsers(new UsersMySqlReposiory())
}
