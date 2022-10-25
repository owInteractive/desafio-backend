export type HttpResponse<T = any> = {
  body: T
  statusCode: number
}
