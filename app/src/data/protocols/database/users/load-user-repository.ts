import { LoadUsers } from '@/domain/usecases/users'

export interface LoadUsersRepository {
  load: (params?: LoadUsersRepository.Params) => Promise<LoadUsersRepository.Result>
}

export namespace LoadUsersRepository {
  export type Params = LoadUsers.Params

  export type Result = LoadUsers.Result

}
