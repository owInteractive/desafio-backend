import { LoadTransactions } from '@/domain/usecases/transactions'

export interface LoadTransactionsRepository {
  load: (
    params: LoadTransactionsRepository.Params
  ) => Promise<LoadTransactionsRepository.Result>
}

export namespace LoadTransactionsRepository {
  export type Params = LoadTransactions.Params

  export type Result = LoadTransactions.Result
}
