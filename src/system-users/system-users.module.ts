import { TypeOrmModule } from '@nestjs/typeorm';
import { Module } from '@nestjs/common';
import { SystemUsersService } from './system-users.service';
import { SystemUsersController } from './system-users.controller';
import { SystemUser } from '../entity/system-user.entity';

@Module({
  imports: [TypeOrmModule.forFeature([SystemUser])],
  providers: [SystemUsersService],
  controllers: [SystemUsersController],
  exports: [SystemUsersService],
})
export class SystemUsersModule {}
