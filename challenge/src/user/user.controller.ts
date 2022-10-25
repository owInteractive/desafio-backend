import { Controller, Get, Post, Body, Put, Param, Delete, HttpException, HttpStatus, UseGuards } from '@nestjs/common';
import { ApiCreatedResponse, ApiTags, ApiBadRequestResponse, ApiOkResponse, ApiNotFoundResponse, ApiAcceptedResponse, ApiBearerAuth } from '@nestjs/swagger';
import { UserService } from './user.service';
import { CreateUserDto } from './dto/create-user.dto';
import { UpdateUserDto, UpdateUserBalanceDto } from './dto/update-user.dto';
import { AuthGuard } from 'src/auth/auth.guard';

@ApiTags('User')
@Controller('user')
export class UserController {
  constructor(private readonly userService: UserService) { }

  ageControll(birthday: Date | any) {
    birthday = new Date(birthday);
    const today = new Date();

    let age = today.getFullYear() - birthday.getFullYear();
    const month = today.getMonth() - birthday.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birthday.getDate()))
      return age - 1;
    return age;
  }

  // Create user if email is not already in use
  @Post()
  @ApiCreatedResponse({ description: 'Created Succesfully' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  async create(@Body() createUserDto: CreateUserDto) {
    if (createUserDto.name && createUserDto.email && createUserDto.birthday) {
      if (this.ageControll(createUserDto.birthday) < 18)
        throw new HttpException('You must be 18 years old or older to register', HttpStatus.BAD_REQUEST);

      return await this.userService.create(createUserDto);
    }

    throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
  }

  // Find all users
  @UseGuards(AuthGuard)
  @Get()
  @ApiOkResponse({ description: 'All users returned successfully' })
  @ApiBearerAuth()
  async findAll() {
    return this.userService.findAll();
  }

  // Find user by id
  @UseGuards(AuthGuard)
  @Get(':id')
  @ApiOkResponse({ description: 'User were returned successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  @ApiBearerAuth()
  async findOne(@Param('id') id: string) {
    const user = await this.userService.findOne(+id);
    if (user) return user;

    throw new HttpException('User not found', HttpStatus.NOT_FOUND);
  }

  // Update user if email is not already in use or if it is the same as the current one
  @UseGuards(AuthGuard)
  @Put(':id')
  @ApiOkResponse({ description: 'The user was updated successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  @ApiBearerAuth()
  async update(@Param('id') id: string, @Body() updateUserDto: UpdateUserDto) {
    if (updateUserDto.name && updateUserDto.email && updateUserDto.birthday) {

      if (this.ageControll(updateUserDto.birthday) < 18)
        throw new HttpException('You must be 18 years old or older to register', HttpStatus.BAD_REQUEST);

      const update = await this.userService.update(+id, updateUserDto);
      if (update.affected === 0) throw new HttpException('User not found', HttpStatus.NOT_FOUND);

      return ({ message: 'User updated successfully' });
    }

    throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
  }

  // Add balance to user
  @UseGuards(AuthGuard)
  @Put('/balance/:id')
  @ApiOkResponse({ description: 'Balance added successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  @ApiBearerAuth()
  async addBalance(@Param('id') id: string, @Body() balance: UpdateUserBalanceDto) {
    return await this.userService.addBalance(+id, balance);
  }

  // Delete user by id if they haven't transactions
  @UseGuards(AuthGuard)
  @Delete(':id')
  @ApiOkResponse({ description: 'The user was deleted successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  @ApiBadRequestResponse({ description: 'Bad Request, check if the user has transactions' })
  @ApiBearerAuth()
  async remove(@Param('id') id: string) {
    const del = await this.userService.remove(+id);
    if (del.affected === 0) throw new HttpException('User cannot be deleted, check if they have transactions and/or balance', HttpStatus.BAD_REQUEST);

      return ({ message: 'User deleted successfully' });
  }
}
