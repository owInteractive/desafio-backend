import { HttpResponse } from '@/presentation/protocols/http'
import { ClientError } from '../errors/client-error'
import { NotFoundError } from '../errors/not-found-error'

export const badRequest = (error: ClientError | Error | any): HttpResponse => ({
  statusCode: error.statusCode || 400,
  body: error,
})

export const ok = (data: any): HttpResponse => ({
  statusCode: 200,
  body: data,
})

export const forbidden = (error: ClientError | any | Error): HttpResponse => ({
  statusCode: error.statusCode || 403,
  body: error,
})

export const noContent = (): HttpResponse => ({
  statusCode: 204,
  body: null,
})

export const serverError = (
  error: ClientError | any | Error
): HttpResponse => ({
  statusCode: error.statusCode || 500,
  body: error,
})

export const notFound = (item: string, details?:string): HttpResponse => ({
  statusCode: 404,
  body: new NotFoundError(item, details),
})
