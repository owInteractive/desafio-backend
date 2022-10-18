import {  RequiredFieldValidation, ValidationComposite } from '@/validation/validators'
import { Validation } from '@/presentation/protocols/validation'
import { makeAddUserControllerValidator } from './add-user-controller-validator'
import { describe, expect, test, vitest } from 'vitest'

vitest.mock('@/validation/validators/validation-composite')

describe('AddUserControllerValidator Factory', () => {
  test('Should call ValidationComposite with all validators', () => {
    makeAddUserControllerValidator()
    const validations: Validation [] = []
    for (const field of ['name', 'email', 'birthDay', 'password']) {
      validations.push(new RequiredFieldValidation(field))
    }


    expect(ValidationComposite).toHaveBeenCalledWith([
      ...validations
    ])
  })
})
