import { Controller, Get, Post, Body, Put, Param, Delete, HttpException, HttpStatus } from '@nestjs/common';
import { ApiCreatedResponse, ApiTags, ApiBadRequestResponse, ApiOkResponse, ApiNotFoundResponse } from '@nestjs/swagger';
import { UserService } from './user.service';
import { CreateUserDto } from './dto/create-user.dto';
import { UpdateUserDto } from './dto/update-user.dto';

@ApiTags('User')
@Controller('user')
export class UserController {
  constructor(private readonly userService: UserService) { }

  // Create user if email is not already in use
  @Post()
  @ApiCreatedResponse({ description: 'Created Succesfully' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  async create(@Body() createUserDto: CreateUserDto) {
    if (createUserDto.name && createUserDto.email && createUserDto.birthday) {
      return await this.userService.create(createUserDto);
    } else {
      throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
    }
  }

  // Find all users
  @Get()
  @ApiOkResponse({ description: 'All users returned successfully' })
  findAll() {
    return this.userService.findAll();
  }

  // Find user by id
  @Get(':id')
  @ApiOkResponse({ description: 'User were returned successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  async findOne(@Param('id') id: string) {
    const user = await this.userService.findOne(+id);
    if (user) {
      return user;
    } else {
      throw new HttpException('User not found', HttpStatus.NOT_FOUND);
    }
  }

  // Update user if email is not already in use or if it is the same as the current one
  @Put(':id')
  @ApiOkResponse({ description: 'The user was updated successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  async update(@Param('id') id: string, @Body() updateUserDto: UpdateUserDto) {
    if (updateUserDto.name && updateUserDto.email && updateUserDto.birthday) {
      const update = await this.userService.update(+id, updateUserDto);
      if (update.affected === 0) {
        throw new HttpException('User not found', HttpStatus.NOT_FOUND);
      } else {
        return ({ message: 'User updated successfully' });
      }
    } else {
      throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
    }
  }

  // Delete user by id
  @Delete(':id')
  @ApiOkResponse({ description: 'The user was deleted successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  remove(@Param('id') id: string) {
    return this.userService.remove(+id);
  }
}
