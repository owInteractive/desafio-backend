import { AddTransactionRepository } from '@/data/protocols/database/transactions/add-transaction-repository'
import { DeleteTransactionByIdRepository } from '@/data/protocols/database/transactions/delete-transaction-by-id-repository'
import { LoadTransactionByUserRepository } from '@/data/protocols/database/transactions/load-transaction-by-user-repository'
import { LoadTransactionsRepository } from '@/data/protocols/database/transactions/load-transactions-repository'
import { LoadTransactions } from '@/domain/usecases/transactions'
import { Op } from 'sequelize'
import TransactionSequelize, {
  TransactionModelSequelize,
} from '../models/Transaction'

export class TransactionsMySqlReposiory
  implements
    AddTransactionRepository,
    LoadTransactionByUserRepository,
    DeleteTransactionByIdRepository,
    LoadTransactionsRepository
{
  async add(
    transaction: AddTransactionRepository.Params
  ): Promise<AddTransactionRepository.Result> {
    const newTransaction = (
      await TransactionSequelize.create(transaction)
    ).toJSON()

    const insertedTransaction = (
      await TransactionSequelize.findOne({
        where: {
          id: newTransaction.id,
        },
        include: {
          all: true,
        },
      })
    ).toJSON()

    return this.formatTransaction(insertedTransaction)
  }

  private formatTransaction(
    transaction: TransactionModelSequelize
  ): AddTransactionRepository.Result {
    const { From, To, ChargebackFrom, ...prunedTransaction } = transaction

    const newTransaction: AddTransactionRepository.Result = {
      ...prunedTransaction,
      from: transaction.From,
      to: transaction.To,
      chargebackFrom: transaction.ChargebackFrom,
    }

    return newTransaction
  }

  async loadByUser(
    params: LoadTransactionByUserRepository.Params
  ): Promise<LoadTransactionByUserRepository.Result> {
    const { page, perPage, userId } = params
    const offset = (page - 1) * perPage

    const transactions = await TransactionSequelize.findAndCountAll({
      where: {
        [Op.or]: {
          from: userId,
          to: userId,
        },
      },
      offset,
      limit: perPage,
      include: {
        all: true,
      },
    })

    const data = transactions.rows.map(transaction =>
      this.formatTransaction(transaction.toJSON())
    )
    const pagination = {
      page,
      perPage,
      total: transactions.count,
      totalPages: Math.ceil(transactions.count / perPage),
    }

    return {
      data,
      pagination,
    }
  }

  async deleteById(
    params: DeleteTransactionByIdRepository.Params
  ): Promise<DeleteTransactionByIdRepository.Result> {
    const result = await TransactionSequelize.destroy({
      where: {
        id: params.id,
      },
    })

    return result > 0
  }

  async load (params: LoadTransactions.Params = {}): Promise<LoadTransactions.Result> {
    const { lastDays, monthAndYear } = params

    const where = {}

    if (lastDays) {
      const date = new Date()
      date.setDate(date.getDate() - lastDays)
      where['createdAt'] = {
        [Op.gte]: date,
      }
    } else if (monthAndYear) {
      const [month, abbreviatedYear] = monthAndYear.split('/').map(Number)
      const year = Number(`20${abbreviatedYear}`)
      where['createdAt'] = {
        [Op.gte]: new Date(year, month - 1, 1),
        [Op.lte]: new Date(year, month, 0),
      }
    }

    const transactions = await TransactionSequelize.findAndCountAll({
      where,
      include: {
        all: true,
      },
    })

    const data = transactions.rows.map(transaction =>
      this.formatTransaction(transaction.toJSON())
    )

    return data
  }
}
