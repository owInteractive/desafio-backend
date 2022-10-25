import { describe, expect, test, vitest } from "vitest";
import moment from 'moment'
import { faker } from "@faker-js/faker";
import { MomentDateValidatorAdapter } from "./moment-date-validator-adapter";

const MOCKED_IS_VALID = faker.datatype.boolean()
vitest.mock('moment', () => {
  const self = {
    default: vitest.fn().mockReturnThis(),
    isValid() {
      return MOCKED_IS_VALID
    },
  }
  return self
})
describe('MomentDateValidatorAdapter', () => {
  function makeSut() {
    return new MomentDateValidatorAdapter()
  }
  test('should call moment with correct date', () => {
    const sut = makeSut()
    const mockedDate = faker.date.future()
    sut.isValidDate(mockedDate)
    expect(moment).toHaveBeenCalledWith(mockedDate)
  });

  test('should return the isValid result', () => {
    const sut = makeSut()
    const mockedDate = faker.date.future()
    const result = sut.isValidDate(mockedDate)
    expect(result).toBe(MOCKED_IS_VALID)
  });
});