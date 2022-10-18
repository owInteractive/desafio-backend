import { Validation } from '@/presentation/protocols'
import { RequiredFieldValidation } from '@/validation/validators/required-field-validator'
import { ValidationComposite } from '@/validation/validators/validation-composite'

export function makeAddUserControllerValidator(): ValidationComposite {
  const validations: Validation[] = []
  const requiredFields = ['name', 'email', 'birthDay', 'password']
  for (const requiredField of requiredFields) {
    validations.push(new RequiredFieldValidation(requiredField))
  }

  return new ValidationComposite(
    validations
  )
}
