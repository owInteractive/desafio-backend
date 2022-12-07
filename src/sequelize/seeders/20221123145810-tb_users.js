module.exports = {
  up: (queryInterface, Sequelize) => {
    return queryInterface.bulkInsert('tb_users', [
      {
        name: 'John',
        email: 'johndoe@email.com',
        birthday: '1995-05-22',
        initialValue: '150.00',
        createdAt: new Date(),
        updatedAt: new Date()
      },
      {
        name: 'John1',
        email: 'john1doe@email.com',
        birthday: '1989-05-22',
        initialValue: '350.00',
        createdAt: new Date(),
        updatedAt: new Date()
      }
    ]);
  },
  down: (queryInterface, Sequelize) => {
    return queryInterface.bulkDelete('tb_users', null, {});
  }
};