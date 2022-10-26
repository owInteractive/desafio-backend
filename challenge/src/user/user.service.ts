import { forwardRef, HttpException, HttpStatus, Inject, Injectable } from '@nestjs/common';
import { Repository } from 'typeorm';
import { CreateUserDto } from './dto/create-user.dto';
import { UpdateUserBalanceDto, UpdateUserDto } from './dto/update-user.dto';
import { User } from './entities/user.entity';
import { TransactionsService } from '../transactions/transaction.service';

@Injectable()
export class UserService {
  constructor(
    @Inject('USER_REPOSITORY')
    private userRepository: Repository<User>,
    @Inject(forwardRef(() => TransactionsService))
    private transaction: TransactionsService
  ) { }

  // Create user if email is not already in use
  async create(createUserDto: CreateUserDto) {
    if (await this.userRepository.findOne({ where: { email: createUserDto.email } })) {
      throw new HttpException('Email already exists', HttpStatus.BAD_REQUEST);
    } else {
      const user = this.userRepository.create(createUserDto);
      await user.save();
      delete user.password;
      delete user.updatedAt;
      return user;
    }
  }

  // Add balance to user
  async addBalance(id: number, balance: UpdateUserBalanceDto) {
    const user = await this.userRepository.findOne({ where: { id } });
    if (user) {
      if (Number(user.balance) + Number(balance.balance) > 0) {
        balance.balance = Number(user.balance) + Number(balance.balance);
        await this.userRepository.update(id, balance);
        user.balance = balance.balance;
        return user;
      }
      throw new HttpException('User balance cannot be negative', HttpStatus.BAD_REQUEST);
    } else {
      throw new HttpException('User not found', HttpStatus.NOT_FOUND);
    }
  }

  // Find user by id
  async findOne(id: number) {
    const user = await this.userRepository.findOne({ where: { id } });
    if (user) {
      delete user.password;
      return user;
    };
  }

  // Find all users in the database
  async findAll() {
    return await this.userRepository.find({ order: { id: 'DESC' } });
  }

  // Find user by email
  async findByEmail(email: string): Promise<User> {
    const user = await this.userRepository.findOne({ where: { email } });
    if (user) return user;

    // If user is not found, throw an error
    throw new HttpException('User not found', HttpStatus.NOT_FOUND);
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
    const user = await this.userRepository.findOne({ where: { id } })
    if (user) {
      if (await this.transaction.findAll(id) || user.balance > 0)
        throw new HttpException('User has transactions', HttpStatus.BAD_REQUEST);

      return await this.userRepository.delete(id);
    }

    throw new HttpException('User not found', HttpStatus.NOT_FOUND);
  }
}
