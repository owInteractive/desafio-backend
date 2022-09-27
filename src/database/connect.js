const knex = require('knex')({
    client: 'mysql2',
    connection: {
        host: 'localhost',
        port: 3306,
        user: 'admin',
        database: 'ow_interactive_challenge',
        password: 'mariadb',
    }
});

module.exports = knex