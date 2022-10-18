import { ClientError } from "./client-error"

export class NotFoundError extends ClientError {
  constructor (item: string) {
    super(`${item} not found`)
    this.statusCode = 404
    this.name = 'NotFoundError'
  }
}