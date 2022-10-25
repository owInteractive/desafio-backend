import {
  AddUserRepository,
  DeleteUserRepository,
  LoadUsersByEmailRepository,
  LoadUsersRepository,
} from '@/data/protocols/database/users'
import { LoadUsersByIdRepository } from '@/data/protocols/database/users/load-user-by-id-repository'
import { DeleteUser } from '@/domain/usecases/users'
import UsersSequelize from '../models/User'

export class UsersMySqlReposiory
  implements
    AddUserRepository,
    LoadUsersRepository,
    LoadUsersByEmailRepository,
    LoadUsersByIdRepository,
    DeleteUserRepository
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

  async loadById(
    params: LoadUsersByIdRepository.Params
  ): Promise<LoadUsersByIdRepository.Result> {
    const user = await UsersSequelize.findOne({
      where: {
        id: params.userId,
      }
    })

    return user as any as LoadUsersByIdRepository.Result
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

  async delete (params?: DeleteUser.Params): Promise<void> {
    await UsersSequelize.destroy({
      where: {
        id: params.userId,
      },
    })
  };
}
