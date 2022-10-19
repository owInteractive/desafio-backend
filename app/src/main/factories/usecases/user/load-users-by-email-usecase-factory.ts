import { DbLoadUsersByEmail } from '@/data/usecases/users'
import { LoadUsersByEmail } from '@/domain/usecases/users'
import { UsersMySqlReposiory } from '@/infra/database/sequelize/UsersMySqlRepository/users-mysql-repository'

export function makeDbLoadUsersByEmail(): LoadUsersByEmail {
  return new DbLoadUsersByEmail(new UsersMySqlReposiory())
}
