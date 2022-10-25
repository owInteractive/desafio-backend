import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { ConfigModule, ConfigService } from '@nestjs/config';
import { UserModule } from './user/user.module';
import { TransactionModule } from './transactions/transaction.module';
import { JwtModule } from '@nestjs/jwt';
import { AuthService } from './auth/auth.service';

@Module({
  imports: [ConfigModule.forRoot({ isGlobal: true }),
  JwtModule.registerAsync({
    inject: [ConfigService],
    useFactory: (config: ConfigService) => ({
      secret: config.get('JWT_SECRET'),
      signOptions: { expiresIn: '30d', algorithm: 'HS256' }
    }),
  }), UserModule, TransactionModule],
  controllers: [AppController],
  providers: [AppService, AuthService],
})
export class AppModule { }
