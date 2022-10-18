import { LoadUsersByIdRepository } from '@/data/protocols/database/users'
import { DeleteUserRepository } from '@/data/protocols/database/users/delete-user-repository'
import { DeleteUser } from '@/domain/usecases/users'
import { NotFoundError } from '@/presentation/errors/not-found-error'

export class DbDeleteUser implements DeleteUser {
  constructor(
    private readonly deleteUserRepository: DeleteUserRepository,
    private readonly loadUsersByIdRepository: LoadUsersByIdRepository
  ) {}
  async delete(params?: DeleteUser.Params): Promise<void> {
    const usersExists = await this.loadUsersByIdRepository.loadById({
      userId: params.userId
    })
    if (!usersExists) {
      throw new NotFoundError('User')
    }
    await this.deleteUserRepository.delete(params)
  }
}
