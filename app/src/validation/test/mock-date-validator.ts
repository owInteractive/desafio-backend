import { DateValidator } from "../protocols/date-validator"

export class DateValidatorSpy implements DateValidator{
  input: string | Date
  isValid: boolean =  true

  isValidDate(input: any) {
    this.input = input
    return this.isValid
  }
}