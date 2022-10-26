import { ApiProperty, PartialType } from '@nestjs/swagger'
import { IsNotEmpty, IsString, IsInt, IsDecimal, IsEnum } from 'class-validator';
import { TransactionType } from '../entities/transaction.entity';
import { CreateTransactionDto } from './create-transaction.dto';

export class UpdateTransactionDto extends PartialType(CreateTransactionDto) {
    @IsNotEmpty()
    @IsInt()
    @ApiProperty({
        type: Number,
        description: 'Transaction userId',
        example: 1
    })
    userId: number;

    @IsNotEmpty()
    @IsDecimal()
    @ApiProperty({
        type: Number,
        description: 'Transaction value',
        example: 100.00
    })
    value: number;

    @IsNotEmpty()
    @IsString()
    @ApiProperty({
        type: String,
        description: 'Transaction description',
        example: 'Transaction description'
    })
    description: string;

    @IsNotEmpty()
    @IsEnum(TransactionType)
    @ApiProperty({
        enum: TransactionType,
        description: 'Transaction type, {CREDIT, DEBIT, REVERSAL}',
        example: 'credit'
    })
    type: TransactionType;
}
