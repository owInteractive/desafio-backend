import { CsvParser } from '@/data/protocols/utils'
import { LoadTransactions } from '@/domain/usecases/transactions'
import { ok, serverError } from '@/presentation/helpers/http-helper'
import { Controller, HttpResponse } from '@/presentation/protocols'

export class LoadTransactionsCsvController implements Controller {
  constructor(
    private readonly loadTransactionsUseCase: LoadTransactions,
    private readonly csvParser: CsvParser
  ) {}
  async handle(
    params: LoadTransactionsCsvController.Request
  ): Promise<LoadTransactionsCsvController.Response> {
    try {
      const transactions = await this.loadTransactionsUseCase.load(params)
      const csv = await this.csvParser.parse(transactions)
      return ok(csv)
    } catch (error) {
      return serverError(error)
    }
  }
}

export namespace LoadTransactionsCsvController {
  export type Request = LoadTransactions.Params
  export type Response = HttpResponse<LoadTransactions.Result>
}