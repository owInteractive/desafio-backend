const { Model } = require('sequelize');

module.exports = (sequelize, DataTypes) => {
  class tb_user extends Model {
  
    static associate(models) {
      // define association here
    }
  }
  tb_user.init({
    name: DataTypes.STRING,
    email: DataTypes.STRING,
    birthday: DataTypes.DATEONLY, 
    initialValue: DataTypes.STRING
  }, {
    sequelize,
    modelName: 'tb_user',
  });
  return tb_user;
};