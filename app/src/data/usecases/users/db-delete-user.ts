import { DeleteUserRepository } from '@/data/protocols/database/users/delete-user-repository'
import { DeleteUser } from '@/domain/usecases/users'

export class DbDeleteUser implements DeleteUser {
  constructor(
    private readonly deleteUserRepository: DeleteUserRepository
  ) {}
  async delete(params?: DeleteUser.Params): Promise<void> {
    await this.deleteUserRepository.delete(params)
  }
}
