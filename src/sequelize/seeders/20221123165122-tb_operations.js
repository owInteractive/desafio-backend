module.exports = {
  up: (queryInterface, Sequelize) => {
    return queryInterface.bulkInsert('tb_operations', [
      {
        typeOperation: 'Crédito',
        createdAT: new Date(),
        updatedAt: new Date()
      },
      {
        typeOperation: 'Débito',
        createdAT: new Date(),
        updatedAt: new Date(),
      },
      {
        typeOperation: 'Estorno',
        createdAT: new Date(),
        updatedAt: new Date(),
      }
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return queryInterface.bulkDelete('tb_operations', null, {});
  }
};