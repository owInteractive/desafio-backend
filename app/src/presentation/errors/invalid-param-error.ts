import { ClientError } from "./client-error"

export class InvalidParamError extends ClientError {
    constructor (paramName: string) {
        super(`Invalid param: ${paramName}`)
        this.statusCode = 404 
        this.name = 'InvalidParamError'
    }
}