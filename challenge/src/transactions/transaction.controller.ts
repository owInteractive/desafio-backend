import { Controller, Get, Post, Body, Put, Param, Delete, HttpException, HttpStatus, Query, UseGuards, StreamableFile, Res } from '@nestjs/common';
import { ApiBadRequestResponse, ApiBearerAuth, ApiBody, ApiCreatedResponse, ApiNotFoundResponse, ApiOkResponse, ApiQuery, ApiTags } from '@nestjs/swagger';
import { TransactionsService } from './transaction.service';
import { CreateTransactionDto } from './dto/create-transaction.dto';
import { UpdateTransactionDto } from './dto/update-transaction.dto';
import { AuthGuard } from '../auth/auth.guard';
import { createReadStream, readFileSync } from 'fs';
import { join } from 'path';
import { getMimeType } from 'stream-mime-type';
import { Response } from 'express';

@ApiTags('Transaction')
@Controller('transactions')
export class TransactionsController {
  constructor(private readonly transactionsService: TransactionsService) { }

  // Create a new transaction for an user
  @UseGuards(AuthGuard)
  @Post()
  @ApiBody({ type: CreateTransactionDto })
  @ApiCreatedResponse({ description: 'Created Succesfully' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  @ApiBearerAuth()
  async create(@Body() createTransactionDto: CreateTransactionDto) {
    if (createTransactionDto.userId && createTransactionDto.value && createTransactionDto.description && createTransactionDto.type) {
      return await this.transactionsService.create(createTransactionDto);
    } else {
      throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
    }
  }

  // Get all transactions for an user
  @UseGuards(AuthGuard)
  @Get(':userId')
  @ApiOkResponse({ description: 'All transactions returned successfully by descending' })
  @ApiNotFoundResponse({ description: 'No transactions found' })
  @ApiBearerAuth()
  async findAll(
    @Param('userId') userId: number,
    @Query('skip') skip?: number | undefined,
    @Query('take') take?: number | undefined,
  ) {
    const transactionsInfo = await this.transactionsService.findAll(+userId, skip, take);
    if (transactionsInfo) {
      return transactionsInfo;
    } else {
      throw new HttpException('No transactions found', HttpStatus.NOT_FOUND);
    }
  }

  // Get transaction by id
  @UseGuards(AuthGuard)
  @Get(':id')
  @ApiOkResponse({ description: 'Transaction were returned successfully' })
  @ApiNotFoundResponse({ description: 'Transaction not found' })
  @ApiBearerAuth()
  async findOne(@Param('id') id: number) {
    const transaction = await this.transactionsService.findOne(+id);
    if (transaction) {
      return transaction;
    } else {
      throw new HttpException('Transaction not found', HttpStatus.NOT_FOUND);
    }
  }

  @UseGuards(AuthGuard)
  @Get('balance/:userId')
  @ApiOkResponse({ description: 'Balance returned successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  @ApiBearerAuth()
  async getBalance(@Param('userId') userId: number) {
    const balance = await this.transactionsService.findUserTransactions(+userId);
    if (balance) {
      return balance;
    } else {
      throw new HttpException('User not found', HttpStatus.NOT_FOUND);
    }
  }

  @Get('download/:userId')
  @ApiOkResponse({ description: 'File downloaded successfully' })
  @ApiNotFoundResponse({ description: 'User not found' })
  async getUserTransactions(@Res({ passthrough: true }) res: Response, @Param('userId') userId: number) {
    const fileName = 'transactions_userId_' + userId;
    const transactions = await this.transactionsService.exportTransactions(+userId);
    if (transactions) {
      const file = createReadStream(join(process.cwd(), 'uploads/' + fileName + '.csv'));
      const stream = new StreamableFile(file);
      const buffer = readFileSync(join(process.cwd(), 'uploads/' + fileName + '.csv'));
      const mimeType = await getMimeType(buffer, { filename: fileName });

      res.set({
        'Content-Type': mimeType,
        'Content-Disposition': `attachment; filename="${fileName}.csv"`,
      });

      return stream;
    } else {
      throw new HttpException('User not found', HttpStatus.NOT_FOUND);
    }
  }

  // Update transaction by id
  @UseGuards(AuthGuard)
  @Put(':id')
  @ApiBody({ type: UpdateTransactionDto })
  @ApiOkResponse({ description: 'The transaction was updated successfully' })
  @ApiNotFoundResponse({ description: 'Transaction not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  @ApiBearerAuth()
  async update(@Param('id') id: string, @Body() updateTransactionDto: UpdateTransactionDto) {
    if (updateTransactionDto.userId && updateTransactionDto.value && updateTransactionDto.description && updateTransactionDto.type) {
      const transaction = await this.transactionsService.update(+id, updateTransactionDto);
      if (transaction.affected === 0) {
        throw new HttpException('Transaction not found', HttpStatus.NOT_FOUND);
      } else {
        return ({ message: 'Transaction updated successfully' });
      }
    } else {
      throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
    }
  }

  // Delete transaction by id
  @UseGuards(AuthGuard)
  @Delete(':id')
  @ApiOkResponse({ description: 'The transaction was deleted successfully' })
  @ApiNotFoundResponse({ description: 'Transaction not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  @ApiBearerAuth()
  async remove(@Param('id') id: string) {
    const del = await this.transactionsService.remove(+id);
    if (del.affected === 0) throw new HttpException('Transaction cannot be deleted, check if they have transactions', HttpStatus.BAD_REQUEST);

    return ({ message: 'Transaction deleted successfully' });
  }
}
