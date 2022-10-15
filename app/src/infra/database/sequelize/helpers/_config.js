import { config } from 'dotenv'
config({
    path: process.env.NODE_ENV === 'test' ? '.env.test' : '.env'
})


export default {
  host: process.env.DB_HOST,
  port: parseInt(process.env.DB_PORT),
  username: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME,
  dialect: process.env.DB_DIALECT || 'mysql',
  logging: false
}
