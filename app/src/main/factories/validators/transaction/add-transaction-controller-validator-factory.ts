import { AddTransactionController } from "@/presentation/controllers/transactions-controllers"
import { Validation } from "@/presentation/protocols"
import { RequiredFieldValidation, ValidationComposite } from "@/validation/validators"
import { FieldShouldBeValidation } from "@/validation/validators/field-should-be-validator"

export function makeAddTransactionControllerValidator(): ValidationComposite {
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

  validations.push(new FieldShouldBeValidation('type', ['credit', 'debt', 'chargeback']))


  return new ValidationComposite(validations)
}