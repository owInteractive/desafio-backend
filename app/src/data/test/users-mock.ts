import { mockUser } from '@/domain/tests/users-mock'
import { AddUserRepository } from '../protocols/database/users/add-user-repository'
import { LoadUsersRepository } from '../protocols/database/users/load-user-repository'

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

export class LoadUsersRepositorySpy implements LoadUsersRepository {
  loadParams: LoadUsersRepository.Params
  loadResult: LoadUsersRepository.Result
  constructor() {
    this.loadResult =[mockUser()]
  }
  async load(params: LoadUsersRepository.Params): Promise<LoadUsersRepository.Result> {
    this.loadParams = params
    return this.loadResult
  }
}