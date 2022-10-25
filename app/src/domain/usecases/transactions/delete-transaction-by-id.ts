import { Transaction } from '@/domain/models'

export interface DeleteTransactionById {
  deleteById: (params: DeleteTransactionById.Params) => Promise<DeleteTransactionById.Result>
}

export namespace DeleteTransactionById {
  export type Params = {
    id: number
  }

  export type Result = boolean
}
