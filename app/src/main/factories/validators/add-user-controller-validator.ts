import { MomentDateValidatorAdapter } from '@/infra/validators/moment-date-validator-adapter'
import { Validation } from '@/presentation/protocols'
import { DateValidation } from '@/validation/validators/date-validator'
import { RequiredFieldValidation } from '@/validation/validators/required-field-validator'
import { ValidationComposite } from '@/validation/validators/validation-composite'

export function makeAddUserControllerValidator(): ValidationComposite {
  const validations: Validation[] = []
  const requiredFields = ['name', 'email', 'birthDay', 'password']
  for (const requiredField of requiredFields) {
    validations.push(new RequiredFieldValidation(requiredField))
  }

  validations.push(new DateValidation(
    'birthDay',
    new MomentDateValidatorAdapter()
  ))  

  return new ValidationComposite(validations)
}
