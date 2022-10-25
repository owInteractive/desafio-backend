import { forwardRef, HttpException, HttpStatus, Inject, Injectable } from '@nestjs/common';
import { Repository } from 'typeorm';
import { CreateTransactionDto } from './dto/create-transaction.dto';
import { UpdateTransactionDto } from './dto/update-transaction.dto';
import { Transaction } from './entities/transaction.entity';
import { UserService } from '../user/user.service';

@Injectable()
export class TransactionsService {
  constructor(
    @Inject('TRANSACTION_REPOSITORY')
    private transactionRepository: Repository<Transaction>,
    @Inject(forwardRef(() => UserService))
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

  async findUserTransactions(userId: number) {
    const user = await this.userService.findOne(userId);
    if (user) {
      const transaction = await this.transactionRepository.createQueryBuilder('transaction')
        .select('SUM(transaction.value)', 'total')
        .where('transaction.userId = :userId', { userId })
        .leftJoin('transaction.user', 'user')
        .getRawOne();
      if (transaction) {
        transaction.total = Number(transaction.total) + Number(user.balance);
        return { user: { name: user.name, email: user.email, birthday: user.birthday, createdAt: user.createdAt }, userTransactions: transaction };
      }
    }
  }

  async exportTransactions(userId: number) {
    const user = await this.userService.findOne(userId);
    if (user) {
      const transactions = await this.transactionRepository.find({ where: { userId } });

      if (transactions) {
        const fs = require('fs');
        const writeStream = fs.createWriteStream('uploads/transactions_userId_' + userId + '.csv');
        await writeStream.write(`Transaction Id, Value, Description, Type, CreatedAt, UpdatedAt\n`);
        transactions.forEach((transaction) => {
          writeStream.write(`${transaction.id}, ${transaction.value}, ${transaction.description}, ${transaction.type}, ${new Date(transaction.createdAt).toLocaleString()}, ${new Date(transaction.updatedAt).toLocaleString()}\n`);
        });
        await writeStream.end();
        if (writeStream) {
          return true; // return true if file is created
        } else {
          throw new HttpException('Error creating file', HttpStatus.INTERNAL_SERVER_ERROR);
        }
      }

      throw new HttpException('No transactions found', HttpStatus.NOT_FOUND);
    }
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
