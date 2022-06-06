import {
  IsAlpha,
  IsDateString,
  IsEmail,
  IsEmpty,
  IsNotEmpty,
  Min,
} from 'class-validator';

export class CreateUserDto {

  @IsNotEmpty()
  name: string;

  @IsEmail()
  email: string;

  @IsDateString()
  birthday: Date;

  @IsEmpty()
  openingBalance: number;

  @IsEmpty()
  age: number;
}
