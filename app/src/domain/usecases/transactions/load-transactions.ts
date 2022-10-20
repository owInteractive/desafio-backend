import { Transaction } from '@/domain/models'

export interface LoadTransactions {
  load: (
    params: LoadTransactions.Params
  ) => Promise<LoadTransactions.Result>
}

export namespace LoadTransactions {
  export type Params = {
    lastDays?: number
    monthAndYear?: string
  } 

  export type Result = Transaction[]
}
