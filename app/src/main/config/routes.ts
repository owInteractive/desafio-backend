import { Express, Router } from 'express'
import {usersRoutes} from '../routes/users-routes'

export function setupRoutes(app: Express) {
    const router = Router()
    usersRoutes(router)
    app.use(router)
}