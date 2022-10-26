import { DataSource } from "typeorm";
import sanitizedConfig from 'config';
const config = sanitizedConfig;

export const databaseProviders = [
    {
        provide: 'DATABASE_CONNECTION',
        useFactory: async () => {
            const dataSource = new DataSource({
                type: 'mysql',
                host: config.DB_HOST,
                port: 3306,
                username: config.DB_USER,
                password: config.DB_PASS,
                database: config.DB_NAME,
                entities: [
                    __dirname + '/../**/*.entity{.ts,.js}',
                ],
                synchronize: true,
            });
            return dataSource.initialize();
        }
    },
];