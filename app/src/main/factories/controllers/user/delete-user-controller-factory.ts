import { DeleteUserController } from '@/presentation/controllers/users-controller/delete-user-controller'
import { Controller } from '@/presentation/protocols'
import { makeDbDeleteUser } from '../../usecases/user'

export function makeDeleteUserController(): Controller {
  return new DeleteUserController(makeDbDeleteUser())
}
