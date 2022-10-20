export interface CsvParser {
  parse: (object: Object) => Promise<string>
}
