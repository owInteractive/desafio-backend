import { MissingParamError } from '@/presentation/errors'
import { describe, expect, test } from 'vitest'
import { RequiredFieldValidation } from './required-field-validator'

function makeSut (): RequiredFieldValidation {
  return new RequiredFieldValidation('any_field')
}

describe('RequiredField Validation', () => {
  test('Should return a MissingParamError if validation fails', () => {
    const sut = makeSut()
    const error = sut.validate({
      any_other_field: 'any_value'
    })

    expect(error).toEqual(new MissingParamError('any_field'))
  })

  test('Should not return if validation succeeds', () => {
    const sut = makeSut()
    const error = sut.validate({
      any_field: 'any_value'
    })

    expect(error).toBeFalsy()
  })
})
