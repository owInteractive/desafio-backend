import { DeleteTransactionById } from '@/domain/usecases/transactions'

export interface DeleteTransactionByIdRepository {
  deleteById: (
    params: DeleteTransactionByIdRepository.Params
  ) => Promise<DeleteTransactionByIdRepository.Result>
}

export namespace DeleteTransactionByIdRepository {
  export type Params = DeleteTransactionById.Params

  export type Result = DeleteTransactionById.Result
}
