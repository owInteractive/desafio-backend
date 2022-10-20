import { faker } from "@faker-js/faker";
import { CsvParser, DateFormatter } from "../protocols/utils";

export class CsvParserSpy implements CsvParser {
  input: Object
  result: string = faker.lorem.words()
  async parse(obj: Object): Promise<string> {
    this.input = obj
    return this.result
  }
}