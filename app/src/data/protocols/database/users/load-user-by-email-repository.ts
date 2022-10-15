import { LoadUsersByEmail } from '@/domain/usecases/users'

export interface LoadUsersByEmailRepository {
  loadByEmail: (params: LoadUsersByEmailRepository.Params) => Promise<LoadUsersByEmailRepository.Result>
}

export namespace LoadUsersByEmailRepository {
  export type Params = LoadUsersByEmail.Params

  export type Result = LoadUsersByEmail.Result

}
