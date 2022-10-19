import { AddTransaction } from '@/domain/usecases/transactions'

export interface AddTransactionRepository {
  add: (user: AddTransactionRepository.Params) => Promise<AddTransactionRepository.Result>
}

export namespace AddTransactionRepository {
  export type Params = AddTransaction.Params

  export type Result = AddTransaction.Result

}
