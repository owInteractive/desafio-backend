import { DeleteTransactionByIdRepository } from '@/data/protocols/database/transactions/delete-transaction-by-id-repository'
import { DeleteTransactionById } from '@/domain/usecases/transactions'

export class DbDeleteTransactionById implements DeleteTransactionById {
  constructor(
    private readonly deleteTransactionByIdRepository: DeleteTransactionByIdRepository
  ) {}

  async deleteById(
    params: DeleteTransactionById.Params
  ): Promise<DeleteTransactionById.Result> {
    return await this.deleteTransactionByIdRepository.deleteById(params)
  }
}
