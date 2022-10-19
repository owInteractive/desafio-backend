import { ClientError } from "./client-error"

export class NotFoundError extends ClientError {
  constructor (item: string, details?:string) {
    super(`Not Found: ${item}`+ (details ? `: ${details}` : ''))
    this.statusCode = 404
    this.name = 'NotFoundError'
  }
}