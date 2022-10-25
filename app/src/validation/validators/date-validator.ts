import { InvalidParamError } from '@/presentation/errors'
import { Validation } from '@/presentation/protocols'
import { DateValidator } from '../protocols/date-validator'

export class DateValidation implements Validation {
  constructor(
    private readonly fieldName: string,
    private readonly dateValidator: DateValidator
  ) {}

  validate(input: any ): Error {
    const dateField = input[this.fieldName]
    const isValidDate = this.dateValidator.isValidDate(dateField)

    if(!isValidDate) {
      return new InvalidParamError(this.fieldName, `the date ${dateField} is not valid`)
    }
  }
}
