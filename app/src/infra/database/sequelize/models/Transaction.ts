import { AddTransactionModel, Transaction, User } from '@/domain/models'
import Sequelize, { Model } from 'sequelize'
import { sequelizeConnection } from '../helpers'
import UsersSequelize from './User'

export type TransactionModelSequelize = {
  id: number,
  description: string,
  amount: number,
  type: 'debt' | 'credit' | 'chargeback',
  chargebackFrom: number,
  ChargebackFrom?: Transaction,
  from: number,
  From?: User,
  To?: User,
  to: number,
  createdAt?: Date
} 
class TransactionSequelize extends Model<TransactionModelSequelize> {}

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
      references: {
        model: UsersSequelize,
        key: 'id',
      },
    },
    to: {
      type: Sequelize.INTEGER,
      allowNull: false,
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
      references: {
        model: TransactionSequelize,
        key: 'id',
      },

    },
    createdAt: {
      type: Sequelize.DATE,
      allowNull: false,
      defaultValue: Sequelize.NOW,
    },
    description: {
      type: Sequelize.STRING,
      allowNull: true,
    },
  },
  {
    createdAt: 'createdAt',
    sequelize: sequelizeConnection,
    tableName: 'transactions',
    modelName: 'Transactions',
  }
)

TransactionSequelize.belongsTo(UsersSequelize, { as: 'From', foreignKey: 'from', onDelete: 'CASCADE' })
TransactionSequelize.belongsTo(UsersSequelize, { as: 'To', foreignKey: 'to',  onDelete: 'CASCADE' })
TransactionSequelize.hasOne(TransactionSequelize, { as: 'ChargebackFrom', foreignKey: 'chargebackFrom', onDelete: 'CASCADE' })
export default TransactionSequelize
