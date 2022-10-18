export class NotFoundError extends Error {
  constructor (item: string) {
    super(`${item} not found`)
    this.name = 'NotFoundError'
  }
}