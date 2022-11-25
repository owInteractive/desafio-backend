const { Model } = require('sequelize');
const tb_operations = require('./tb_operations');
const tb_user = require('./tb_user');

module.exports = (sequelize, DataTypes) => {
  class tb_movements extends Model {

    static associate(models) {
      tb_movements.hasOne(tb_user);
      tb_movements.hasOne(tb_operations);
    }
  }
  tb_movements.init({
    idUser: DataTypes.INTEGER,
    idTypeOperation: DataTypes.INTEGER,
    valueOperation: DataTypes.STRING
  }, {
    sequelize,
    modelName: 'tb_movements',
  });
  return tb_movements;
};