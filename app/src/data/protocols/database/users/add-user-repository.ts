import { AddUser } from '@/domain/usecases/users'

export interface AddUserRepository {
  add: (user: AddUserRepository.Params) => Promise<AddUserRepository.Result>
}

export namespace AddUserRepository {
  export type Params = AddUser.Params

  export type Result = AddUser.Result

}
