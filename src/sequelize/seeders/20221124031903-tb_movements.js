module.exports = {
  up: (queryInterface, Sequelize) => {
    return queryInterface.bulkInsert('tb_movements', [
      {
        idUser: 1,
        idTypeOperation: 1,
        valueOperation: '500.00',
        createdAT: new Date(),
        updatedAt: new Date()
      },
      {
        idUser: 1,
        idTypeOperation: 1,
        valueOperation: '600.00',
        createdAT: new Date(),
        updatedAt: new Date()
      },
      {
        idUser: 1,
        idTypeOperation: 2,
        valueOperation: '300.00',
        createdAT: new Date(),
        updatedAt: new Date()
      },
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return queryInterface.bulkDelete('tb_movements', null, {});
  }
};