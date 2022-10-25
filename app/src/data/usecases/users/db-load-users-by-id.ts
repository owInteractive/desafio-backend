import { LoadUsersByIdRepository } from '@/data/protocols/database/users'
import { LoadUsersById } from '@/domain/usecases/users'

export class DbLoadUsersById implements LoadUsersById {
  constructor(
    private readonly loadUsersByIdRepository: LoadUsersByIdRepository
  ) {}
  async loadById(params: LoadUsersById.Params): Promise<LoadUsersById.Result> {
    return this.loadUsersByIdRepository.loadById(params)
  }
}
