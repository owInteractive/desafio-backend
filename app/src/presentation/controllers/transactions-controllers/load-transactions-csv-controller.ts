import { CsvParser } from '@/data/protocols/utils'
import { LoadTransactions } from '@/domain/usecases/transactions'
import { FileResponseGenerator } from '@/presentation/helpers/file-response'
import { ok, serverError } from '@/presentation/helpers/http-helper'
import { Controller, HttpResponse } from '@/presentation/protocols'
import { FileResponse } from '@/presentation/protocols/file-response'

export class LoadTransactionsCsvController implements Controller {
  constructor(
    private readonly loadTransactionsUseCase: LoadTransactions,
    private readonly csvParser: CsvParser
  ) {}
  async handle(
    params?: LoadTransactionsCsvController.Request
  ): Promise<LoadTransactionsCsvController.Response> {
    try {
      const transactions = await this.loadTransactionsUseCase.load(params)
      const csv = (await Promise.all(
        transactions.map(async (transaction) => {
          return await this.csvParser.parse(JSON.stringify(transaction))
        })
      )).join('\n')
      let name = 'transactions'

      if(params?.lastDays) {
        name += `-last${params.lastDays}days`
      } else if(params?.monthAndYear) {
        name += `-${params.monthAndYear}`
      }
      return ok(new FileResponseGenerator().generate({
        data: csv,
        name,
        ext: 'csv',
        mimetype: 'text/csv',
      }))
    } catch (error) {
      return serverError(error)
    }
  }
}

export namespace LoadTransactionsCsvController {
  export type Request = LoadTransactions.Params
  export type Response = HttpResponse<FileResponse>
}