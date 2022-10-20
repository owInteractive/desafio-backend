import {  RequiredFieldValidation, ValidationComposite } from '@/validation/validators'
import { Validation } from '@/presentation/protocols/validation'
import { describe, expect, test, vitest } from 'vitest'
import { makeLoadTransactionsByUserControllerValidator } from './load-transactions-by-user-controller-validator-factory'
import { AddTransactionController } from '@/presentation/controllers/transactions-controllers'

vitest.mock('@/validation/validators/validation-composite')

describe('AddTransactionControllerValidator Factory', () => {
  test('Should call ValidationComposite with all validators', () => {
    makeLoadTransactionsByUserControllerValidator()
    const validations: Validation<AddTransactionController.Request>[] = [
      new RequiredFieldValidation('page'),
      new RequiredFieldValidation('perPage'),
      new RequiredFieldValidation('userId'),
    ]
  
    
    expect(ValidationComposite).toHaveBeenCalledWith([
      ...validations
    ])
  })
})
