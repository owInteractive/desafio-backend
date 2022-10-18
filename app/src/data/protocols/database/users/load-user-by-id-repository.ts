import { LoadUsersById } from '@/domain/usecases/users'

export interface LoadUsersByIdRepository {
  loadById: (params?: LoadUsersByIdRepository.Params) => Promise<LoadUsersByIdRepository.Result>
}

export namespace LoadUsersByIdRepository {
  export type Params = LoadUsersById.Params

  export type Result = LoadUsersById.Result

}
