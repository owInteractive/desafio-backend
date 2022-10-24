import { Controller, Get, Post, Body, Put, Param, Delete, HttpException, HttpStatus, Query } from '@nestjs/common';
import { ApiBadRequestResponse, ApiBody, ApiCreatedResponse, ApiNotFoundResponse, ApiOkResponse, ApiQuery, ApiTags } from '@nestjs/swagger';
import { TransactionsService } from './transaction.service';
import { CreateTransactionDto } from './dto/create-transaction.dto';
import { UpdateTransactionDto } from './dto/update-transaction.dto';

@ApiTags('Transaction')
@Controller('transactions')
export class TransactionsController {
  constructor(private readonly transactionsService: TransactionsService) { }

  @Post()
  @ApiBody({ type: CreateTransactionDto })
  @ApiCreatedResponse({ description: 'Created Succesfully' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  async create(@Body() createTransactionDto: CreateTransactionDto) {
    if (createTransactionDto.userId && createTransactionDto.value && createTransactionDto.description && createTransactionDto.type) {
      return await this.transactionsService.create(createTransactionDto);
    } else {
      throw new HttpException('Missing required fields, please check the documentation', HttpStatus.BAD_REQUEST);
    }
  }

  @Get(':userId')
  @ApiOkResponse({ description: 'All transactions returned successfully by descending' })
  @ApiNotFoundResponse({ description: 'No transactions found' })
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

  @Get(':id')
  @ApiOkResponse({ description: 'Transaction were returned successfully' })
  @ApiNotFoundResponse({ description: 'Transaction not found' })
  async findOne(@Param('id') id: number) {
    const transaction = await this.transactionsService.findOne(+id);
    if (transaction) {
      return transaction;
    } else {
      throw new HttpException('Transaction not found', HttpStatus.NOT_FOUND);
    }
  }

  @Put(':id')
  @ApiBody({ type: UpdateTransactionDto })
  @ApiOkResponse({ description: 'The transaction was updated successfully' })
  @ApiNotFoundResponse({ description: 'Transaction not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
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

  @Delete(':id')
  @ApiOkResponse({ description: 'The transaction was deleted successfully' })
  @ApiNotFoundResponse({ description: 'Transaction not found' })
  @ApiBadRequestResponse({ description: 'Bad Request' })
  remove(@Param('id') id: string) {
    return this.transactionsService.remove(+id);
  }
}
