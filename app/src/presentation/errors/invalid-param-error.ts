import { ClientError } from "./client-error"

export class InvalidParamError extends ClientError {
    constructor (paramName: string, details?: string) {
        super(`Invalid param: ${paramName}`+(details?`. ${details}`:''))
        this.statusCode = 404 
        this.name = 'InvalidParamError'
    }
}