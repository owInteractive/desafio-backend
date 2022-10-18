import { ClientError } from "./client-error"

export class EmailAlreadyInUseError extends ClientError {
    constructor (email: string) {
      super()
      this.name = 'EmailAlreadyInUseError'
      this.message = `The received email ${email} is already in use.`
    }
  }
  