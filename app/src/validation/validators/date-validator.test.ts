import { InvalidParamError } from '@/presentation/errors'
import { faker } from '@faker-js/faker'
import { describe, expect, test } from 'vitest'
import { DateValidatorSpy } from '../test/mock-date-validator'
import { DateValidation } from './date-validator'

function makeSut(fieldDate: string= 'any_field') {
  const dateValidatorSpy = new DateValidatorSpy()
  const sut = new DateValidation(fieldDate, dateValidatorSpy)

  return {
    sut,
    dateValidatorSpy,
  }
}

describe('Date Validation', () => {
  test('should call dateValidator with correct params', () => {
    const { sut, dateValidatorSpy } = makeSut('someDate')
    const mockedObject = {
      someDate: 'invalid date'
    }

    sut.validate(mockedObject)
    expect(dateValidatorSpy.input).toEqual(mockedObject.someDate)
  })

  test('should return invalidParamError if dateValidator returns false', () => {
    const { sut, dateValidatorSpy } = makeSut('someDate')
    dateValidatorSpy.isValid = false
    const mockedObject = {
      someDate: 'invalid date'
    }

    const result = sut.validate(mockedObject)
    expect(result).toEqual(new InvalidParamError('someDate', `the date invalid date is not valid`))
  });

  test('should not return if dateValidator returns true', () => {
    const { sut, dateValidatorSpy } = makeSut('someDate')
    const mockedObject = {
      someDate: 'invalid date'
    }

    const result = sut.validate(mockedObject)
    expect(result).toBe(undefined)
  });
})
