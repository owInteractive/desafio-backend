import { CsvParserSpy } from '@/data/test/mock-csv-parser'
import { LoadTransactionsSpy } from '@/domain/tests/mock-transactions'
import { FileResponseGenerator } from '@/presentation/helpers/file-response'
import { badRequest, ok, serverError } from '@/presentation/helpers/http-helper'
import { faker } from '@faker-js/faker'
import { describe, expect, test, vitest } from 'vitest'
import { LoadTransactionsCsvController } from './load-transactions-csv-controller'

describe('LoadTransactionsCsvController', () => {
  function makeSut() {
    const loadTransactions = new LoadTransactionsSpy()
    const csvParserSpy = new CsvParserSpy()
    const sut = new LoadTransactionsCsvController(loadTransactions, csvParserSpy)

    return {
      sut,
      loadTransactions,
      csvParserSpy,
    }
  }
  describe('handle()', () => {
    test('should call loadTransactionsUseCase with correct params', async () => {
      const { sut, loadTransactions } = makeSut()
      const request = {
        lastDays: faker.datatype.number(),
      }

      await sut.handle(request)
      expect(loadTransactions.loadParams).toEqual(request)
    })

    test('should return 500 if loadTransactionsUseCase throws', async () => {
      const { sut, loadTransactions } = makeSut()
      vitest.spyOn(loadTransactions, 'load').mockRejectedValueOnce(new Error())

      const response = await sut.handle({})
      expect(response).toEqual(serverError(new Error()))
    })

    test('should call csvParser with correct params', async () => {
      const { sut, loadTransactions, csvParserSpy } = makeSut()

      await sut.handle({})
      expect(csvParserSpy.input.length).toBe(loadTransactions.loadResult.length)
    });

    test('should return 500 if csvParser throws', async () => {
      const { sut, csvParserSpy } = makeSut()
      vitest.spyOn(csvParserSpy, 'parse').mockRejectedValueOnce(new Error())

      const response = await sut.handle({})
      expect(response).toEqual(serverError(new Error()))
    })

    test('should return 200 if csvParser succeeds', async () => {
      const { sut, csvParserSpy } = makeSut()

      const response = await sut.handle({})
      expect(response).toEqual(ok(new FileResponseGenerator().generate({
        data: csvParserSpy.result,
        name: 'transactions',
        ext: 'csv',
        mimetype: 'text/csv',
      })))
    })
  })
})
