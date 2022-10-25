import { DeleteUser } from '@/domain/usecases/users'

export interface DeleteUserRepository {
  delete: (params?: DeleteUserRepository.Params) => Promise<void>
}

export namespace DeleteUserRepository {
  export type Params = DeleteUser.Params
}
