import { Express } from 'express'
import { bodyParser, contentType, cors } from '../middlewares'

export function setupMiddlewares (app: Express): void {
  app.use(contentType)
  app.use(bodyParser)
  app.use(cors)
}
