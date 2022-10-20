import { CsvParser } from '@/data/protocols/utils'
import jsonToCsv ,{  FieldInfo } from 'json2csv'
export class JsonToCSVAdapter implements CsvParser {
  constructor(private readonly options: FieldInfo<any>[]) {}

  async parse(json: string): Promise<string> {
    const json2csv = new jsonToCsv.AsyncParser({
      fields: this.options,
      defaultValue: '',
    })
    json2csv.input.push(Buffer.from(json))
    json2csv.input.push(null)
    return await json2csv.promise()
  }
}
