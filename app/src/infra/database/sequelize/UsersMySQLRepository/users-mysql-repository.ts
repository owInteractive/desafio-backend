import { AddUserRepository } from '@/data/protocols/database/users/add-user-repository'
import UsersSequelize from '../models/Users'

export class UsersMySqlReposiory implements AddUserRepository {
  async add(user: AddUserRepository.Params): Promise<AddUserRepository.Result> {
    const newUser = await UsersSequelize.create(user)
    return newUser as any as AddUserRepository.Result
  }
}
