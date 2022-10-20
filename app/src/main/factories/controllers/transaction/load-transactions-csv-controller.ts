import { JsonToCSVAdapter } from "@/infra/utils/csv-parser/json-to-csv-adapter"
import { LoadTransactionsCsvController } from "@/presentation/controllers/transactions-controllers"
import { Controller } from "@/presentation/protocols"
import { makeLoadTransactionsUseCase } from "../../usecases/transaction"

export function makeLoadTransactionsCsvController(): Controller {
  const loadTransactionsUseCase = makeLoadTransactionsUseCase()
  const jsonToCSVAdaptar = new JsonToCSVAdapter([
    { label: 'ID da transação', value: 'id' },
    { label: 'Descrição', value: 'description' },
    { label: 'Valor', value: 'amount' },
    { label: 'Tipo', value: 'type' },
    { label: 'Pagante', value: 'from.name' },
    { label: 'Recebedor', value: 'to.name' },
    { label: 'Estorno de', value: 'chargebackFrom.id' },
    { label: 'Data', value: 'createdAt' },
  ])
  return new LoadTransactionsCsvController(
    loadTransactionsUseCase,
    jsonToCSVAdaptar
  )
}