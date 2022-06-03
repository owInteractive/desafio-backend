import {
  Controller,
  Post,
  ParseUUIDPipe,
  Param,
  Body,
  Get,
  Query,
  ParseIntPipe,
  Delete,
  HttpCode,
  HttpStatus,
  Res,
  UseGuards,
} from '@nestjs/common';
import { Transaction } from '../entity/transaction.entity';
import { CreateTransactionDto } from '../dto/create-transaction.dto';
import { TransactionsService } from './transactions.service';
import { AuthGuard } from '@nestjs/passport';

@UseGuards(AuthGuard('jwt'))
@Controller('api/v1/transactions')
export class TransactionsController {
  constructor(private readonly transactionsService: TransactionsService) {}

  @Get(':id/download')
  async findAll(
    @Param('id', new ParseUUIDPipe()) id: string,
    @Res() res,
    @Query('time') time?: string,
  ) {
    return await this.transactionsService.findAll(id, res, time);
  }

  @Get(':id')
  async findAllByUser(
    @Param('id', new ParseUUIDPipe()) userId: string,
    @Query('skip', new ParseIntPipe()) skip?: number,
    @Query('take', new ParseIntPipe()) take?: number,
  ) {
    return await this.transactionsService.findAllByUser(userId, skip, take);
  }

  @Get(':id/balance')
  async getBalance(@Param('id', new ParseUUIDPipe()) userId: string) {
    return await this.transactionsService.getBalance(userId);
  }

  @Post(':id')
  async create(
    @Param('id', new ParseUUIDPipe()) userId: string,
    @Body() transaction: CreateTransactionDto,
  ): Promise<Transaction> {
    return await this.transactionsService.create(userId, transaction);
  }

  @Delete('/:id')
  @HttpCode(HttpStatus.NO_CONTENT)
  async delete(@Param('id', new ParseUUIDPipe()) id: string): Promise<void> {
    await this.transactionsService.delete(id);
  }
}
