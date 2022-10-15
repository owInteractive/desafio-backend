import { AddUser } from '@/domain/usecases/users'
import UsersSequelize from '../models/Users'

export class UsersMySqlReposiory implements AddUser {
  async add(user: AddUser.Params): Promise<AddUser.Result> {
    const newUser = await UsersSequelize.create(user)
    return newUser as any as AddUser.Result
  }
}
