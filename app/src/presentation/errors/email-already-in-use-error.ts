export class EmailAlreadyInUseError extends Error {
    constructor (email) {
      super()
      this.name = 'EmailAlreadyInUseError'
      this.message = `The received email ${email} is already in use.`
    }
  }
  