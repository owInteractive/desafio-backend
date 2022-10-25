import { LoadUsersController } from '@/presentation/controllers/users-controller'
import { Controller } from '@/presentation/protocols'
import { makeDbLoadUsers } from '../../usecases/user'

export function makeLoadUsersController(): Controller {
  return new LoadUsersController(makeDbLoadUsers())
}
