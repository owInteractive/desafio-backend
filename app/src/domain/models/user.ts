import { Transaction } from './transaction'

export type AddUserModel = {
  name: string
  email: string
  birthDay: Date | string
  role?: string
  password: string
  initialBalance?: number
  createdAt?: Date
}

export type User = {
  id?: number
  name: string
  email: string
  birthDay: Date | string
  role?: string
  password: string
  transactions?: Transaction[]
  createdAt?: Date
  updatedAt?: Date
}
