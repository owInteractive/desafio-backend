import { HttpException, HttpStatus, Inject, Injectable } from '@nestjs/common';
import { Repository } from 'typeorm';
import { CreateTransactionDto } from './dto/create-transaction.dto';
import { UpdateTransactionDto } from './dto/update-transaction.dto';
import { Transaction } from './entities/transaction.entity';
import { User } from '../user/entities/user.entity';
import { UserService } from 'src/user/user.service';

@Injectable()
export class TransactionsService {
  constructor(
    @Inject('TRANSACTION_REPOSITORY')
    private transactionRepository: Repository<Transaction>,
    private userService: UserService,
  ) { }

  // Create transaction if user exists
  async create(createTransactionDto: CreateTransactionDto) {
    if (await this.transactionRepository.findOne({
      where: {
        userId: createTransactionDto.userId,
        value: createTransactionDto.value,
        description: createTransactionDto.description,
        type: createTransactionDto.type,
      }
    })) {
      throw new HttpException('Transaction already exists', HttpStatus.BAD_REQUEST);
    } else {
      return await this.transactionRepository.save(createTransactionDto);
    }
  }

  async findAll(userId: number, skip?: number, take?: number) {
    skip = skip ? skip : 0;
    take = take ? take : 100;
    const user = await this.userService.findOne(userId);
    if (user) {
      const transaction = await this.transactionRepository.find({
        where: { userId },
        order: { id: 'DESC' },
        skip,
        take,
      });
      if (transaction) {
        return { user: { name: user.name, email: user.email, birthday: user.birthday, createdAt: user.createdAt }, userTransactions: transaction };
      } else {
        throw new HttpException('No transactions found', HttpStatus.NOT_FOUND);
      }
    }
  }

  async findOne(id: number) {
    return await this.transactionRepository.findOne({ where: { id } });
  }

  async update(id: number, updateTransactionDto: UpdateTransactionDto) {
    const transaction = await this.transactionRepository.findOne({ where: { id } });
    if (transaction.userId !== updateTransactionDto.userId) {
      throw new HttpException('User does not exist', HttpStatus.BAD_REQUEST);
    } else {
      return await this.transactionRepository.update(id, updateTransactionDto);
    }
  }

  async remove(id: number) {
    if (await this.transactionRepository.findOne({ where: { id } })) {
      return await this.transactionRepository.delete(id);
    } else {
      throw new HttpException('Transaction not found', HttpStatus.NOT_FOUND);
    }
  }
}
