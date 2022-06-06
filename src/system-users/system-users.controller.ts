import { SystemUsersService } from './system-users.service';
import {
  Body,
  Controller,
  Get,
  HttpCode,
  HttpStatus,
  Param,
  ParseUUIDPipe,
  Post,
} from '@nestjs/common';
import { SystemUser } from '../entity/system-user.entity';

@Controller('api/v1/system-users')
export class SystemUsersController {
  constructor(private readonly systemUserService: SystemUsersService) {}

  @Get()
  async findAll(): Promise<SystemUser[]> {
    return await this.systemUserService.findAll();
  }

  @Get(':id')
  async findOne(
    @Param('id', new ParseUUIDPipe()) id: string,
  ): Promise<SystemUser> {
    return await this.systemUserService.findOne(id);
  }

  @Post()
  @HttpCode(HttpStatus.CREATED)
  async create(@Body() systemUser: SystemUser): Promise<SystemUser> {
    return await this.systemUserService.create(systemUser);
  }
}
