import { LoadUsersByIdController } from '@/presentation/controllers/users-controller/load-user-by-id-controller'
import { Controller } from '@/presentation/protocols'
import { makeDbLoadUsersById } from '../../usecases/user'

export function makeLoadUsersByIdController(): Controller {
  return new LoadUsersByIdController(makeDbLoadUsersById())
}
