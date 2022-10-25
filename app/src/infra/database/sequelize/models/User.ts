import { User } from '@/domain/models'
import Sequelize, { Model, Optional } from 'sequelize'
import { sequelizeConnection } from '../helpers'

class UsersSequelize extends Model<User, Optional<User, 'id'>> {}

UsersSequelize.init(
  {
    id: {
      type: Sequelize.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    birthDay: {
      type: Sequelize.DATE,
      allowNull: false,
    },
    email: {
      type: Sequelize.STRING,
      allowNull: false,
      unique: true,
    },
    name: {
      type: Sequelize.STRING,
    },
    password: {
      type: Sequelize.STRING,
      allowNull: false,
    },
    createdAt: {
        type: Sequelize.DATE,
        allowNull: false,
        defaultValue: Sequelize.NOW,
    },
    updatedAt: {
        type: Sequelize.DATE,
        allowNull: true,
    },
    role: {
        type: Sequelize.STRING,
        allowNull: true,
    },

  },
  {
    createdAt: 'createdAt',
    updatedAt: 'updatedAt',
    sequelize: sequelizeConnection,
    tableName: 'users',
    modelName: 'Users',
  },

)

export default UsersSequelize