const { Model } = require('sequelize');

module.exports = (sequelize, DataTypes) => {
  class tb_operations extends Model {
    /**
     * Helper method for defining associations.
     * This method is not a part of Sequelize lifecycle.
     * The `models/index` file will call this method automatically.
     */
    static associate(models) {
      // define association here
    }
  }
  tb_operations.init({
    typeOperation: DataTypes.STRING
  }, {
    sequelize,
    modelName: 'tb_operations',
  });
  return tb_operations;
};