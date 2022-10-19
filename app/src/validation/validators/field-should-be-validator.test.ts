import { InvalidParamError } from "@/presentation/errors";
import { describe, expect, test } from "vitest";
import { FieldShouldBeValidation } from "./field-should-be-validator";

describe('FileShouldBeValidation', () => {
  describe('validate()', () => {
    test('should return InvalidParamError if validation fails', () => {
      const sut = new FieldShouldBeValidation('any_field', ['any_value', 'any_other_value'])
      const error = sut.validate({
        any_field: 'invalid_value'
      })

      expect(error).toEqual(new InvalidParamError('any_field', 'The value should be any_value or any_other_value'))
    });

    test('should not return if validation succeeds', () => {
      const sut = new FieldShouldBeValidation('any_field', ['any_value', 'any_other_value'])
      const error = sut.validate({
        any_field: 'any_value'
      })

      expect(error).toBeFalsy()
    })
  });
});