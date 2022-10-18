import { InvalidParamError } from '@/presentation/errors'
import { Validation } from '@/presentation/protocols'
import { DateValidator } from '../protocols/date-validator'

export class DateValidation implements Validation {
  constructor(
    private readonly fieldName: string,
    private readonly dateValidator: DateValidator
  ) {}

  validate(input: any ): Error {
    const isValidDate = this.dateValidator.isValidDate(input[this.fieldName])

    if(!isValidDate) {
      return new InvalidParamError(this.fieldName)
    }
  }
}
