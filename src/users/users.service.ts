import {
  Injectable,
  NotFoundException,
  ForbiddenException,
  Inject,
} from '@nestjs/common';
import { User } from '../entity/user.entity';
import { Repository, SelectQueryBuilder } from 'typeorm';
import { InjectRepository } from '@nestjs/typeorm';
import * as dayjs from 'dayjs';
import { CreateUserDto } from 'src/dto/create-user.dto';

@Injectable()
export class UsersService {
  constructor(
    @InjectRepository(User)
    private readonly userRepository: Repository<User>,
  ) {}

  async findAll(): Promise<User[]> {
    return await this.userRepository.find({
      order: {
        createdAt: 'DESC',
      },
      select: [
        'id',
        'name',
        'email',
        'age',
        'openingBalance',
        'createdAt',
        'updatedAt',
      ],
    });
  }

  async findTransactions(id: string) {
    return this.userRepository.find({
      where: { id: id },
      relations: ['transactions'],
    });
  }

  async findOne(id: string): Promise<User> {
    try {
      return await this.userRepository.findOneOrFail(id);
    } catch (error) {
      throw new NotFoundException(error.message);
    }
  }

  async updateOpeningBalance(
    id: string,
    openingBalance: number,
  ): Promise<User> {
    const user = await this.findOne(id);
    user.openingBalance = openingBalance;
    return await this.userRepository.save(user);
  }

  async create(user: CreateUserDto): Promise<User> {
    user.age = dayjs().diff(user.birthday, 'year');
    if (user.age < 18)
      throw new ForbiddenException({
        message: 'You must be 18 years old to register',
      });
    try {
      return await this.userRepository.save(this.userRepository.create(user));
    } catch (error) {
      throw new ForbiddenException({ message: error.message });
    }
  }

  async update(id: string, userUpdates: User): Promise<User> {
    const user = await this.findOne(id);
    if (userUpdates.birthday) {
      user.age = dayjs().diff(userUpdates.birthday, 'year');
    }
    this.userRepository.merge(user, userUpdates);
    return await this.userRepository.save(user);
  }

  async delete(id: string): Promise<void> {
    const [{transactions}] = await this.findTransactions(id);
    if (transactions && transactions.length)
      throw new ForbiddenException({
        message: 'You can not delete a user with transactions',
      });
    await this.userRepository.softDelete(id);
  }
}
