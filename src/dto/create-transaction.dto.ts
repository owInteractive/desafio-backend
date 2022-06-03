import { IsEnum, IsNotEmpty, IsNumber, IsPositive, NotEquals } from "class-validator";
import { Entity } from "typeorm";
import { TransactionTypes } from '../constants/transaction-types.enum';
import {User} from '../entity/user.entity';
export class CreateTransactionDto{
  
  @IsEnum(TransactionTypes)
  @IsNotEmpty()
  type: TransactionTypes;

  @IsNumber()
  @IsNotEmpty()
  @IsPositive()
  @NotEquals(0)
  amount: number;

  user: User;
  userId: string;
}


