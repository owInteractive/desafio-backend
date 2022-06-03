import { TypeOrmModule } from '@nestjs/typeorm';
import { User } from '../entity/user.entity';
/**
 * SEQUELIZE variable is stored in a file named
 * 'constants' so it can be easily reused anywhere
 * without being subject to human error.
 */

export const databaseProviders = [
  {
    provide: 'MARIADB',
    useFactory: async () =>
      TypeOrmModule.forRoot({
        type: 'mariadb',
        host: process.env.DATABASE_HOST,
        port: Number(process.env.DATABASE_PORT),
        username: process.env.DATABASE_USER,
        password: process.env.DATABASE_PASSWORD,
        database: process.env.DATABASE_NAME,
        entities: [User],
        synchronize: true,
      }),
  },
];
