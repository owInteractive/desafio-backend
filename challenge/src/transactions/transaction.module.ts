import { Module } from '@nestjs/common';
import { DatabaseModule } from '../database/database.module';
import { UserModule } from '../user/user.module';
import { TransactionsService } from './transaction.service';
import { TransactionsController } from './transaction.controller';
import { transactionProviders } from './transaction.provider';


@Module({
  imports: [DatabaseModule, UserModule],
  controllers: [TransactionsController],
  providers: [...transactionProviders, TransactionsService],
  exports: [TransactionsService]
})
export class TransactionModule { }
