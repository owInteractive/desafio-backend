import { forwardRef, Module } from '@nestjs/common';
import { DatabaseModule } from '../database/database.module';
import { TransactionsService } from './transaction.service';
import { TransactionsController } from './transaction.controller';
import { transactionProviders } from './transaction.provider';
import { UserModule } from 'src/user/user.module';
import { AuthService } from 'src/auth/auth.service';
import { JwtModule } from '@nestjs/jwt';
import { ConfigService } from '@nestjs/config';


@Module({
  imports: [DatabaseModule, forwardRef(() => UserModule),
    JwtModule.registerAsync({
      inject: [ConfigService],
      useFactory: (config: ConfigService) => ({
        secret: config.get('JWT_SECRET'),
        signOptions: { expiresIn: '30d', algorithm: 'HS256' }
      }),
    })],
  controllers: [TransactionsController],
  providers: [...transactionProviders, TransactionsService, AuthService],
  exports: [TransactionsService]
})

export class TransactionModule { }