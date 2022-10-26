import { DataSource } from 'typeorm';
import { Transaction } from './entities/transaction.entity';

export const transactionProviders = [
    {
        provide: 'TRANSACTION_REPOSITORY',
        useFactory: (dataSource: DataSource) => dataSource.getRepository(Transaction),
        inject: ['DATABASE_CONNECTION'],
    },
];