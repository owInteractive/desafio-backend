const { Sequelize, DataTypes } = require("sequelize");
const database = require("../config/db");

const Transaction = database.define("transaction", {
    id: { type: DataTypes.INTEGER, autoIncrement: true, allowNull: false, primaryKey: true },
    operation_type: { type: Sequelize.ENUM, values: ["DÉBITO", "CRÉDITO", "ESTORNO"] },
    amount: { type: DataTypes.DECIMAL(16, 2), allowNull: false },
    short_date: { type: DataTypes.STRING(7), allowNull: false },
    deleted: { type: DataTypes.BOOLEAN, allowNull: false, defaultValue: false },
    comment: { type: DataTypes.STRING(1024), allowNull: true }
});

module.exports = Transaction;
