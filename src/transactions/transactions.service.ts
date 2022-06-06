import { User } from '../entity/user.entity';
import * as dayjs from 'dayjs';
import { unlink } from 'fs';
import { Inject, Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { CreateTransactionDto } from '../dto/create-transaction.dto';
import { Between, MoreThan, Repository } from 'typeorm';
import { Transaction } from '../entity/transaction.entity';
import { UsersService } from '../users/users.service';
import { TransactionTypes } from '../constants/transaction-types.enum';
import { Response } from 'express';
const ObjectsToCsv = require('objects-to-csv');

@Injectable()
export class TransactionsService {
  constructor(
    @InjectRepository(Transaction)
    private readonly transactionRepository: Repository<Transaction>,
    @Inject(UsersService) private readonly userService: UsersService,
  ) {}

  async findAll(id: string, res: Response, time?: string) {
    const { balance } = await this.getBalance(id);
    if (!time) {
      const data = await this.transactionRepository.find({
        relations: ['user'],
        select: ['id', 'amount', 'type', 'createdAt'],
        where: { userId: id },
      });

      const tempFilePath = await this.convertDataToCvs(data, 'all', balance);
      return res.download(tempFilePath, () => {
        unlink(tempFilePath, () => {});
      });
    }
    if (time.includes('/')) {
      const [month, year] = time.split('/');
      let startDate: string | Date = dayjs(`20${year}-${month}-01`)
        .startOf('month')
        .format('YYYY-MM-DD HH:mm:ss');
      startDate = new Date(startDate);
      let endDate: string | Date = dayjs(`20${year}-${month}-01`)
        .endOf('month')
        .format('YYYY-MM-DD HH:mm:ss');
      endDate = new Date(endDate);
      const data = await this.transactionRepository.find({
        where: { createdAt: Between(startDate, endDate), userId: id },
        relations: ['user'],
      });
      const tempFilePath = await this.convertDataToCvs(data, time, balance);
      return res.download(tempFilePath, () => {
        unlink(tempFilePath, () => {});
      });
    }
    if (Number(time)) {
      let startDate: string | Date = dayjs()
        .subtract(Number(time), 'day')
        .format('YYYY-MM-DD 00:00:00');
      startDate = new Date(startDate);
      const data = await this.transactionRepository.find({
        where: { createdAt: MoreThan(startDate), userId: id },
        relations: ['user'],
      });
      const tempFilePath = await this.convertDataToCvs(
        data,
        `last-${time}-days`,
        balance,
      );
      res.download(tempFilePath);
      return res.download(tempFilePath, () => {
        unlink(tempFilePath, () => {});
      });
    }
  }

  async getBalance(userId: string) {
    const user = await this.userService.findOne(userId);
    let { balance } = await this.transactionRepository
      .createQueryBuilder('transaction')
      .select('SUM(transaction.amount)', 'balance')
      .getRawOne();
    return { user, balance: user.openingBalance + balance };
  }

  async findAllByUser(userId: string, skip?: number, take?: number) {
    const user = await this.userService.findOne(userId);
    const transactions = await this.transactionRepository.find({
      where: { userId },
      order: { createdAt: 'DESC' },
      skip,
      take,
    });
    return { user, transactions };
  }

  async create(
    userId: string,
    transaction: CreateTransactionDto,
  ): Promise<Transaction> {
    const user = await this.userService.findOne(userId);
    transaction.user = user;
    transaction.userId = userId;
    if (transaction.type === TransactionTypes.DEBIT)
      transaction.amount = -transaction.amount;

    return await this.transactionRepository.save(transaction);
  }

  async delete(id: string) {
    await this.transactionRepository.delete(id);
  }
  // converts object array to csv string
  async convertDataToCvs(data: Transaction[], filter: string, balance) {
    const transactions = data.map((item, index) => {
      return {
        id: item.id,
        type: item.type,
        amount: Math.abs(item.amount),
        createdAt: dayjs(item.createdAt).format('YYYY-MM-DD HH:mm:ss'),
        userID: !index ? item.user.id : '',
        userName: !index ? item.user.name : '',
        email: !index ? item.user.email : '',
        birthday: !index ? dayjs(item.user.birthday).format('YYYY-MM-DD') : '',
        openingBalance: !index ? item.user.openingBalance : '',
        balance: !index ? balance : '',
      };
    });
    const filePath = `${dayjs().unix()}-${filter}-transactions.csv`.replace(
      '/',
      '-',
    );
    const csv = new ObjectsToCsv(transactions);
    try {
      await csv.toDisk(filePath);
      return filePath;
    } catch (error) {
      throw new Error(error);
    }
  }
}
