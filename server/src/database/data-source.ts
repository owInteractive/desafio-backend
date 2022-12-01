import { DataSource } from "typeorm";
import * as dotenv from 'dotenv'
dotenv.config()

// definição do banco de dados
export const dataSource = new DataSource({
    type: 'mysql',
    host: process.env.HOST,
    port: parseInt(process.env.PORTDB || ''),
    username: process.env.USERNAMEDB,
    password: process.env.PASSWORD,
    database: process.env.DATABASE,
    synchronize: true,
    // logging: true,
    entities: [
        process.env.NODE_ENV === 'production' ? 'dist/entities/*.js' : 'src/entities/*.ts',
    ],
})
