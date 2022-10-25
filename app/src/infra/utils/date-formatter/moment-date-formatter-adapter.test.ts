import { faker } from '@faker-js/faker'
import moment from 'moment'
import { describe, expect, test, vitest } from 'vitest'
import { MomentDateFormatter } from './moment-date-formatter-adapter'

const MOCKED_DATE = faker.date.past().toDateString()
vitest.mock('moment', () => {
  const self = {
    default: vitest.fn().mockReturnThis(),
    format() {
      return MOCKED_DATE
    },
  }
  return self
})

describe('MomentDateFormatter', () => {
  function makeSut(dateFormat: string = 'YYYY-MM-DD') {
    return new MomentDateFormatter(dateFormat)
  }

  describe('format()', () => {
    test('should call moment with correct params', () => {
      const sut = makeSut()
      const mockedDate = faker.date.past()
      sut.format(mockedDate)
      expect(moment).toHaveBeenCalledWith(mockedDate)
    })

    test('should return format result', () => {
      const dateFormat = 'YYYY-MM-DD HH:mm:ss'
      const sut = makeSut(dateFormat)
      const mockedDate = faker.date.past()
      const result = sut.format(mockedDate)
      expect(result).toBe(MOCKED_DATE)
    })
  })
})
