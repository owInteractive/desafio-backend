import { mockUser } from '@/domain/tests/users-mock'
import { LoadUsersByEmailRepository, LoadUsersByIdRepository } from '../protocols/database/users'
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

export class LoadUsersByEmailRepositorySpy implements LoadUsersByEmailRepository {
  loadByEmailParams: LoadUsersByEmailRepository.Params
  loadByEmailResult: LoadUsersByEmailRepository.Result
  constructor() {
    this.loadByEmailResult = mockUser()
  }
  async loadByEmail(params: LoadUsersByEmailRepository.Params): Promise<LoadUsersByEmailRepository.Result> {
    this.loadByEmailParams = params
    return this.loadByEmailResult
  }
}

export class LoadUsersByIdRepositorySpy implements LoadUsersByIdRepository {
  loadByIdParams: LoadUsersByIdRepository.Params
  loadByIdResult: LoadUsersByIdRepository.Result
  constructor() {
    this.loadByIdResult = mockUser()
  }
  async loadById(params: LoadUsersByIdRepository.Params): Promise<LoadUsersByIdRepository.Result> {
    this.loadByIdParams = params
    return this.loadByIdResult
  }
}