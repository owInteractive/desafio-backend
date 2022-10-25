import { InvalidParamError } from '@/presentation/errors'
import { Validation } from '@/presentation/protocols'

export class FieldShouldBeValidation implements Validation {
  constructor (
    private readonly fieldName: string,
    private readonly possibleValues: string[] | number[]) {}

  validate (input: any): Error {
    if (!this.possibleValues.includes(input[this.fieldName] as never)) {
      // @ts-ignore
      const possibleValuesFormatted = new Intl.ListFormat('en-US', { style: 'long', type: 'disjunction' }).format(this.possibleValues)
      return new InvalidParamError(this.fieldName, `The value should be ${possibleValuesFormatted}`)
    }
  }
}
