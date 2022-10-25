import { AddTransactionRepository } from "@/data/protocols/database/transactions/add-transaction-repository"
import { LoadUsersByIdRepository } from "@/data/protocols/database/users"
import { AddTransaction } from "@/domain/usecases/transactions"
import { NotFoundError } from "@/presentation/errors"

export class DbAddTransaction implements AddTransaction {
  constructor (
    private readonly addTransactionRepository: AddTransactionRepository,
    private readonly loadUsersByIdRepository: LoadUsersByIdRepository
  ) {}

  async add (params: AddTransaction.Params): Promise<AddTransaction.Result> {
    const userFromExists = await this.loadUsersByIdRepository.loadById({userId: params.from})
    if (!userFromExists) {
      throw new NotFoundError('from', `The user ${params.from} does not exists`)
    }

    const userToExists = await this.loadUsersByIdRepository.loadById({userId: params.to})
    if (!userToExists) {
      throw new NotFoundError('to', `The user ${params.to} does not exists`)
    }

    return this.addTransactionRepository.add(params)
  }
}