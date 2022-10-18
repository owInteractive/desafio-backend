import { DateValidator } from "@/validation/protocols/date-validator";
import moment from 'moment'

export class MomentDateValidatorAdapter implements DateValidator {
  isValidDate(inputDate: Date | string): boolean {
    return moment(inputDate).isValid()
  }
}