import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { JwtModule } from '@nestjs/jwt';
import { PassportModule } from '@nestjs/passport';
import { SystemUsersModule } from '../system-users/system-users.module';
import { AuthService } from './auth.service';
import { AuthController } from './auth.controller';
import { LocalStrategy } from './strategies/local.strategies';
import { JwtStrategy } from './strategies/jwt.strategies';

@Module({
  imports: [
    ConfigModule.forRoot(),
    PassportModule,
    SystemUsersModule,
    JwtModule.register({
      privateKey: process.env.JWT_PRIVATE_KEY,
      signOptions: {
        expiresIn: '1d',
      }
    }),
  ],
  providers: [AuthService, LocalStrategy, JwtStrategy],
  controllers: [AuthController],
})
export class AuthModule {}
