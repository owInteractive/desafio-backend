import { AddTransactionModel, Transaction, } from '@/domain/models'
import Sequelize, { Model, Optional } from 'sequelize'
import { sequelizeConnection } from '../helpers'
import UsersSequelize from './User'

class TransactionSequelize extends Model<
  Transaction,
  AddTransactionModel
> {
}

TransactionSequelize.init(
  {
    id: {
      type: Sequelize.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    amount: {
      type: Sequelize.FLOAT,
      allowNull: false,
    },
    from: {
      type: Sequelize.INTEGER,
      allowNull: false,
      field: 'fromId',
      references: {
        model: UsersSequelize,
        key: 'id',
      },
    },
    to: {
      type: Sequelize.INTEGER,
      allowNull: false,
      field: 'toId',
      references: {
        model: UsersSequelize,
        key: 'id',
      },
    },
    type: {
      type: Sequelize.STRING,
      allowNull: false,
    },
    chargebackFrom: {
      type: Sequelize.INTEGER,
      allowNull: true,
      field: 'chargebackFromId',
      references: {
        model: TransactionSequelize,
        key: 'id',
      }
    },
    createdAt: {
      type: Sequelize.DATE,
      allowNull: false,
      defaultValue: Sequelize.NOW,
    },
    description: {
      type: Sequelize.STRING,
      allowNull: true,
    }
  },
  {
    createdAt: 'createdAt',
    sequelize: sequelizeConnection,
    tableName: 'transactions',
    modelName: 'Transactions',
  }
)
TransactionSequelize.belongsTo(UsersSequelize, {
  foreignKey: 'toId',
})

TransactionSequelize.belongsTo(UsersSequelize, {
  foreignKey: 'fromId',
})


export default TransactionSequelize
