import { HttpResponse } from '@/presentation/protocols/http'
import { NotFoundError } from '../errors/not-found-error'

export const badRequest = (error: Error): HttpResponse => ({
  statusCode: 400,
  body: error
})

export const ok = (data: any): HttpResponse => ({
  statusCode: 200,
  body: data
})

export const forbidden = (error: Error): HttpResponse => ({
  statusCode: 403,
  body: error
})

export const noContent = (): HttpResponse => ({
  statusCode: 204,
  body: null
})

export const serverError = (error: Error): HttpResponse => ({
  statusCode: 500,
  body: error
})

export const notFound = (item: string): HttpResponse => ({
  statusCode: 404,
  body: new NotFoundError(item)
})