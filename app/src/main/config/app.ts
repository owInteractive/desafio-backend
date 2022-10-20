import express from 'express'
import { setupMiddlewares } from './middlewares'
import { setupRoutes } from './routes'
import { setupDocs } from './setup-docs'

const app = express()
setupDocs(app)
setupMiddlewares(app)
setupRoutes(app)

export default app
