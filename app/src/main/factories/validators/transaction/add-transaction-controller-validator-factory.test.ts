import {  RequiredFieldValidation, ValidationComposite } from '@/validation/validators'
import { Validation } from '@/presentation/protocols/validation'
import { describe, expect, test, vitest } from 'vitest'
import { makeAddTransactionControllerValidator } from './add-transaction-controller-validator-factory'
import { AddTransactionController } from '@/presentation/controllers/transactions-controllers'
import { FieldShouldBeValidation } from '@/validation/validators/field-should-be-validator'

vitest.mock('@/validation/validators/validation-composite')

describe('AddTransactionControllerValidator Factory', () => {
  test('Should call ValidationComposite with all validators', () => {
    makeAddTransactionControllerValidator()
    const validations: Validation<AddTransactionController.Request>[] = []
    const requiredFields = [
      'amount',
      'type',
      'from',
      'to',
    ]
    for (const requiredField of requiredFields) {
      validations.push(new RequiredFieldValidation(requiredField))
    }
  
  validations.push(new FieldShouldBeValidation('type', ['credit', 'debit', 'chargeback']))
    
    expect(ValidationComposite).toHaveBeenCalledWith([
      ...validations
    ])
  })
})
