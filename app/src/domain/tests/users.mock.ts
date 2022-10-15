import { faker } from '@faker-js/faker'
import { User } from '../models'
import { AddUser, LoadUsersById } from '../usecases/users'
import { LoadUsersByEmail } from '../usecases/users/load-users-by-email'

export function mockUser(): User {
  return {
    id: faker.datatype.number(),
    name: faker.name.fullName(),
    email: faker.internet.email(),
    password: faker.internet.password(),
    brithDay: faker.date.past(),
    role: faker.helpers.arrayElement(['admin', 'user']),
    createdAt: faker.date.past(),
    updatedAt: faker.date.past(),
  }
}

export class LoadUsersByIdSpy implements LoadUsersById {
  loadByIdResult: LoadUsersById.Result
  loadByIdParams: LoadUsersById.Params
  constructor() {
    this.loadByIdResult = mockUser()
  }
  async loadById(params: LoadUsersById.Params): Promise<LoadUsersById.Result> {
    this.loadByIdParams = params
    return new Promise((resolve) => resolve(this.loadByIdResult))
  }
}

export class LoadUsersByEmailSpy implements LoadUsersByEmail {
    loadByEmailResult: LoadUsersByEmail.Result
    loadByEmailParams: LoadUsersByEmail.Params
    constructor() {
      this.loadByEmailResult = mockUser()
    }
    async loadByEmail(params: LoadUsersByEmail.Params): Promise<LoadUsersByEmail.Result> {
      this.loadByEmailParams = params
      return new Promise((resolve) => resolve(this.loadByEmailResult))
    }
  }

export class AddUserSpy implements AddUser {
  addResult: AddUser.Result
  addParams: AddUser.Params
  constructor() {
    this.addResult = mockUser()
  }
  async add(user: AddUser.Params): Promise<AddUser.Result> {
    this.addParams = user
    return new Promise((resolve) => resolve(this.addResult))
  }
}
