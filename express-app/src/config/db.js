const { Sequelize } = require("sequelize");
const config = require("./conf");

const sequilize = new Sequelize(config);

module.exports = sequilize;
