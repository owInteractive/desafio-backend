import { ClientError } from "./client-error"

export class MissingParamError extends ClientError {
    constructor (paramName: string) {
        super(`Missing param: ${paramName}`)
        this.statusCode = 400 
        this.name = 'MissingParamError'
    }
}