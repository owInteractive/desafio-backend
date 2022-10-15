import { mockUser } from '@/domain/tests/users-mock'
import { AddUserRepository } from '../protocols/database/users/add-user-repository'

export class AddUserRepositorySpy implements AddUserRepository {
  addParams: AddUserRepository.Params
  addResult: AddUserRepository.Result
  constructor() {
    this.addResult = mockUser()
  }
  async add(params: AddUserRepository.Params): Promise<AddUserRepository.Result> {
    this.addParams = params
    return this.addResult
  }
}