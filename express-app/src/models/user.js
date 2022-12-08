const { Sequelize, DataTypes } = require("sequelize");
const database = require("../config/db");


const User = database.define("user", {
    id: { type: DataTypes.INTEGER, autoIncrement: true, allowNull: false, primaryKey: true },
    name: { type: DataTypes.STRING(128), allowNull: false },
    email: { type: DataTypes.STRING(128), allowNull: false, unique: true },
    birthday: { type: DataTypes.DATE, allowNull: false },
    balance: { type: DataTypes.DECIMAL(16,2), allowNull: false, defaultValue: 0}
});

module.exports = User;
