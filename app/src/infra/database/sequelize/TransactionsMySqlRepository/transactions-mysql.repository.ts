import { AddTransactionRepository } from '@/data/protocols/database/transactions/add-transaction-repository'
import TransactionSequelize, {
  TransactionModelSequelize,
} from '../models/Transaction'

export class TransactionsMySqlReposiory implements AddTransactionRepository {
  async add(
    transaction: AddTransactionRepository.Params
  ): Promise<AddTransactionRepository.Result> {
    const newTransaction = (await TransactionSequelize.create(transaction)).toJSON()
    

    const insertedTransaction = (await TransactionSequelize.findOne({
      where: {
        id: newTransaction.id,
      },
      include: {
        all: true
   
      }
    })).toJSON()
    
    return this.formatTransaction(insertedTransaction)
  }

  private formatTransaction(
    transaction: TransactionModelSequelize
  ): AddTransactionRepository.Result {
    const { From, To, ChargebackFrom, ...prunedTransaction} = transaction
    
    const newTransaction: AddTransactionRepository.Result = {
      ...prunedTransaction,
      from: transaction.From,
      to: transaction.To,
      chargebackFrom: transaction.ChargebackFrom,
    }


    return newTransaction
  }
}
