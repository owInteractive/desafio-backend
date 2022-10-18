import { ClientError } from '@/presentation/errors'
import { Validation } from '@/presentation/protocols'

export class ValidationSpy implements Validation {
  input: any
  error: ClientError = undefined
  validate(input: any): ClientError {
    this.input = input
    return this.error
  }
}
