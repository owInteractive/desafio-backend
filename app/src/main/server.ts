import { sequelizeConnection } from '@/infra/database/sequelize/helpers'
import app from './config/app'
const PORT = process.env.PORT || 3000
async function run() {
  try {
    console.log('Starting database connection...')
    await sequelizeConnection.authenticate()
    console.log('Database connection started successfully!')
    
    const server = app.listen(PORT, () => {
        console.log(`Server running at http://localhost:${PORT}`)
    })

    const exitSignals: NodeJS.Signals[] = ['SIGINT', 'SIGTERM', 'SIGQUIT']
    exitSignals.map(sig => {
        process.on(sig, () => {
            server.close(() => {
                console.log(`Server closed at http://localhost:${PORT}`)
                sequelizeConnection.close().then(() => {
                    console.log('Database connection closed successfully!')
                })
            })
        })
    })
  } catch (error) {
    console.error('Error starting server:', error)
  }
}

run()
.catch(console.error)
