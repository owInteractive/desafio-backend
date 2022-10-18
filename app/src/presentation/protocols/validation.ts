import { ClientError } from "../errors";

export interface Validation {
  validate: (input: any) => ClientError  | undefined
}
