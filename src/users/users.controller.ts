import { TypeOrmModule } from '@nestjs/typeorm';
import { UsersService } from './users.service';
import {
  Body,
  Catch,
  Controller,
  Delete,
  Get,
  HttpCode,
  HttpStatus,
  Param,
  ParseUUIDPipe,
  Post,
  Put,
  UseGuards,
} from '@nestjs/common';
import { User } from 'src/entity/user.entity';
import { CreateUserDto } from '../dto/create-user.dto';
import { AuthGuard } from '@nestjs/passport';

@UseGuards(AuthGuard('jwt'))
@Controller('api/v1/users')
export class UsersController {
  constructor(private readonly UsersService: UsersService) {}

  @Get()
  async findAll(): Promise<User[]> {
    return await this.UsersService.findAll();
  }

  @Get(':id')
  async findOne(@Param('id', new ParseUUIDPipe()) id: string): Promise<User> {
    return await this.UsersService.findOne(id);
  }

  @Post()
  @HttpCode(HttpStatus.CREATED)
  async create(@Body() user: CreateUserDto): Promise<User> {
    return await this.UsersService.create(user);
  }

  @Put(':id')
  async update(
    @Body() user,
    @Param('id', new ParseUUIDPipe()) id: string,
  ): Promise<User> {
    return await this.UsersService.update(id, user);
  }

  @Put('/:id/openingBalance')
  async updateOpeningBalance(
    @Body() { openingBalance }: { openingBalance: number },
    @Param('id', new ParseUUIDPipe()) id: string,
  ) {
    return await this.UsersService.updateOpeningBalance(id, openingBalance);
  }

  @Delete(':id')
  @HttpCode(HttpStatus.NO_CONTENT)
  async delete(@Param('id', new ParseUUIDPipe()) id: string): Promise<void> {
    await this.UsersService.delete(id);
  }
}
