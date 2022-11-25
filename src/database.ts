import { Sequelize } from 'sequelize-typescript';
import 'dotenv/config';

const sequelize = new Sequelize({
  host: "127.0.0.1",
  database: "desafio-back-end",
  username: "root",
  password: "123456",
  dialect: 'mysql',
  dialectOptions: { decimalNumbers: true },
  models: ['./models'],
  repositoryMode: false
});

export default sequelize;