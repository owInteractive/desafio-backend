import { describe, expect, test, vitest } from 'vitest'
import jsonToCsv from 'json2csv'
import { JsonToCSVAdapter } from './json-to-csv-adapter'
import { faker } from '@faker-js/faker'

const MOCKED_VALUE = faker.lorem.text()
const PUSH_FUNCTION = vitest.fn()
vitest.mock('json2csv', () => ({
  default: {
    AsyncParser: vitest.fn().mockImplementation(() => ({
      input: {
        push: PUSH_FUNCTION,
      },
      promise: vitest.fn().mockResolvedValue(MOCKED_VALUE),
    })),
  },
}))

describe('JsonToCSVAdapter', () => {
  describe('parse()', () => {
    test('should call AsyncParser with correct params', async () => {
      const fields = [
        {
          label: 'any_label',
          value: 'any_key',
        },
        {
          label: 'any_label',
          value: 'any_value',
        },
      ]
      const sut = new JsonToCSVAdapter(fields)
      await sut.parse(JSON.stringify({ any_key: 'any_value' }))
      expect(jsonToCsv.AsyncParser).toHaveBeenCalledWith({
        fields,
        defaultValue: '',
      })
    })

    test('should call input.push with the data', async () => {
      const fields = [
        {
          label: 'any_label',
          value: 'any_key',
        },
        {
          label: 'any_label',
          value: 'any_value',
        },
      ]
      const sut = new JsonToCSVAdapter(fields)
      const data = JSON.stringify({ any_key: 'any_value' })
      await sut.parse(data)
      expect(PUSH_FUNCTION.mock.calls[0][0]).toEqual(Buffer.from(data))
      expect(PUSH_FUNCTION.mock.calls[1][0]).toEqual(null)
    });

    test('should return valid data', async () => {
      const fields = [
        {
          label: 'any_label',
          value: 'any_key',
        },
        {
          label: 'any_label',
          value: 'any_value',
        },
      ]
      const sut = new JsonToCSVAdapter(fields)
      const data = JSON.stringify({ any_key: 'any_value' })
      const result = await sut.parse(data)
      expect(result).toEqual(MOCKED_VALUE)
    });
  })
})
