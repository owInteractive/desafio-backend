import { HttpException, HttpStatus, Inject, Injectable } from '@nestjs/common';
import { Repository } from 'typeorm';
import { CreateUserDto } from './dto/create-user.dto';
import { UpdateUserDto } from './dto/update-user.dto';
import { User } from './entities/user.entity';

@Injectable()
export class UserService {
  constructor(
    @Inject('USER_REPOSITORY')
    private userRepository: Repository<User>) { }

  // Create user if email is not already in use
  async create(createUserDto: CreateUserDto) {
    if (await this.userRepository.findOne({ where: { email: createUserDto.email } })) {
      throw new HttpException('Email already exists', HttpStatus.BAD_REQUEST);
    } else {
      return this.userRepository.save(createUserDto);
    }
  }

  // Find all users in the database
  async findAll() {
    return await this.userRepository.find({ order: { id: 'DESC' } });
  }

  // Find user by id
  async findOne(id: number) {
    return await this.userRepository.findOne({ where: { id } });
  }


  // Update user if email is not already in use or if it is the same as the current one
  async update(id: number, updateUserDto: UpdateUserDto) {
    const user = await this.userRepository.findOne({ where: { email: updateUserDto.email } });
    if (user.id !== id) {
      throw new HttpException('Email already in use', HttpStatus.BAD_REQUEST);
    } else {
      return await this.userRepository.update(id, updateUserDto);
    }
  }

  // Delete user by id
  async remove(id: number) {
    if (await this.userRepository.findOne({ where: { id } })) {
      return await this.userRepository.delete(id);
    } else {
      throw new HttpException('User not found', HttpStatus.NOT_FOUND);
    }
  }
}
