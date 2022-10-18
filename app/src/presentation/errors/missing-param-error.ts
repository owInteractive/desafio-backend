import { ClientError } from "./client-error"

export class MissingParamError extends ClientError {
    constructor (paramName: string) {
        super(`Missing param: ${paramName}`)
        this.statusCode = 404 
        this.name = 'MissingParamError'
    }
}