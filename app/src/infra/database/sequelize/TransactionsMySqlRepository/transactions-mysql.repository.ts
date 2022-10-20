import { AddTransactionRepository } from '@/data/protocols/database/transactions/add-transaction-repository'
import { DeleteTransactionByIdRepository } from '@/data/protocols/database/transactions/delete-transaction-by-id-repository'
import { LoadTransactionByUserRepository } from '@/data/protocols/database/transactions/load-transaction-by-user-repository'
import { Op } from 'sequelize'
import TransactionSequelize, {
  TransactionModelSequelize,
} from '../models/Transaction'

export class TransactionsMySqlReposiory implements AddTransactionRepository, LoadTransactionByUserRepository,DeleteTransactionByIdRepository {
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

  async loadByUser(params: LoadTransactionByUserRepository.Params): Promise<LoadTransactionByUserRepository.Result> {
    const { page, perPage, userId } = params
    const offset = (page - 1) * perPage

    const transactions = await TransactionSequelize.findAndCountAll({
      where: {
        [Op.or]: {
          from: userId,
          to: userId,
        }
      },
      offset,
      limit: perPage,
      include: {
        all: true,
      }
    })

    const data = transactions.rows.map(transaction => this.formatTransaction(transaction.toJSON()))
    const pagination = {
      page,
      perPage,
      total: transactions.count,
      totalPages: Math.ceil(transactions.count / perPage)
    }

    return {
      data,
      pagination
    }
  }

  async deleteById(params: DeleteTransactionByIdRepository.Params): Promise<DeleteTransactionByIdRepository.Result> {
    const result = await TransactionSequelize.destroy({

      where: {
        id: params.id
      },
    })

    return result > 0
  }
}
