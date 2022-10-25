import { faker } from "@faker-js/faker";
import { DateFormatter } from "../protocols/utils";

export class DateFormatterSpy implements DateFormatter {
  dateFormat: string = 'YYYY-MM-DD HH:mm:ss'
  inputDate: string | Date
  finalDate: string = faker.date.past().toDateString()
  format(inputDate: string|Date): string {
    this.inputDate = inputDate
    return this.finalDate
  }
}