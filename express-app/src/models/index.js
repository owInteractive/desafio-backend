const sequelize = require("../config/db");
const User = require("./user");
const Transaction = require("./transaction");


Transaction.belongsTo(User, { constraint: true, foreignKey: "user_id" });
User.hasMany(Transaction, { foreignKey: "user_id" })

const db = {
    User,
    Transaction,
    sequelize
}

module.exports = db;
