import { Validation } from "@/presentation/protocols";
import { RequiredFieldValidation, ValidationComposite } from "@/validation/validators";

export function makeLoadTransactionsByUserControllerValidator(): Validation {
  return new ValidationComposite([
    new RequiredFieldValidation('page'),
    new RequiredFieldValidation('perPage'),
    new RequiredFieldValidation('userId'),
  ])
}