import {
  AddUserRepository,
  LoadUsersByEmailRepository,
  LoadUsersRepository,
} from '@/data/protocols/database/users'
import UsersSequelize from '../models/Users'

export class UsersMySqlReposiory
  implements AddUserRepository, LoadUsersRepository, LoadUsersByEmailRepository
{
  async add(user: AddUserRepository.Params): Promise<AddUserRepository.Result> {
    const newUser = await UsersSequelize.create(user)
    return newUser as any as AddUserRepository.Result
  }

  /**
   * 
   * Returns all users from database.
   * By default it returns all users ordered by createdAt in descending order.
   */
  async load(
    params?: LoadUsersRepository.Params
  ): Promise<LoadUsersRepository.Result> {
    const users = await UsersSequelize.findAll({
      order: [['createdAt', params?.order || 'DESC']],
    })

    return users as any as LoadUsersRepository.Result
  }

  async loadByEmail(
    params: LoadUsersByEmailRepository.Params
  ): Promise<LoadUsersByEmailRepository.Result> {
    const users = await UsersSequelize.findOne({
      where: {
        email: params.email,
      },
    })

    return users as any as LoadUsersByEmailRepository.Result
  }
}
