export class ClientError extends Error {
  statusCode: number
  constructor (message: string = '') {
    super(message)
  }
}