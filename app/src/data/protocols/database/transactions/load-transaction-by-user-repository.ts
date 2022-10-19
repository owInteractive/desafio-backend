import { LoadTransactionByUser } from '@/domain/usecases/transactions'

export interface LoadTransactionByUserRepository {
  loadByUser: (
    params: LoadTransactionByUserRepository.Params
  ) => Promise<LoadTransactionByUserRepository.Result>
}

export namespace LoadTransactionByUserRepository {
  export type Params = LoadTransactionByUser.Params

  export type Result = LoadTransactionByUser.Result
}
