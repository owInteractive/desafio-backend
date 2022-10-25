import { config } from 'dotenv'
config({
  path: process.env.NODE_ENV === 'test' ? '.env.test' : '.env',
})
import { sequelizeConfig } from './config'
import { Sequelize } from 'sequelize'

function getSequelizeInstance() {
  if (process.env.NODE_ENV !== 'test') {
    return new Sequelize(sequelizeConfig)
  }

  return new Sequelize('sqlite::memory:')
}

export const sequelizeConnection = getSequelizeInstance()