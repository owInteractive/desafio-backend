import { Express, Router } from 'express'
import { transactionsRoutes, usersRoutes } from '../routes'

export function setupRoutes(app: Express) {
    const router = Router()
    usersRoutes(router)
    transactionsRoutes(router)
    app.use(router)
}