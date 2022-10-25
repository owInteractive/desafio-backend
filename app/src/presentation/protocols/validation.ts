import { ClientError } from "../errors";

export interface Validation<T = any> {
  validate: (input: T) => ClientError  | undefined
}
