import { AddUserRepository, LoadUsersRepository } from '@/data/protocols/database/users'
import UsersSequelize from '../models/Users'

export class UsersMySqlReposiory implements AddUserRepository, LoadUsersRepository {
  async add(user: AddUserRepository.Params): Promise<AddUserRepository.Result> {
    const newUser = await UsersSequelize.create(user)
    return newUser as any as AddUserRepository.Result
  }

  async load(params?: LoadUsersRepository.Params): Promise<LoadUsersRepository.Result> {
    const users = await UsersSequelize.findAll({
      order: [
        ['createdAt', params?.order || 'DESC']
      ]
    })

    return users as any as LoadUsersRepository.Result
  }
}
