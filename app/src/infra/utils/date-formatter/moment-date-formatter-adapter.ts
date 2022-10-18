import { DateFormatter } from "@/data/protocols/utils";
import moment from 'moment'
export class MomentDateFormatter implements DateFormatter {
  constructor(private readonly dateFormat: string) {}

  format(inputDate: string | Date): string {
    return moment(inputDate).format(this.dateFormat)
  }
}