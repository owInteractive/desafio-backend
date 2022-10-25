import { ApiProperty, PartialType } from '@nestjs/swagger'
import { IsEmail, IsNotEmpty, IsString, IsDate, IsNumber, IsDecimal } from 'class-validator';
import { CreateUserDto } from './create-user.dto';

export class UpdateUserDto extends PartialType(CreateUserDto) {
    @IsNotEmpty()
    @IsString()
    @ApiProperty({
        type: String,
        description: 'User name',
        example: 'John Doe'
    })
    name: string;

    @IsNotEmpty()
    @IsEmail()
    @ApiProperty({
        type: String,
        description: 'User email, must be unique',
        example: 'johndoe_@email.com'
    })
    email: string;

    @IsNotEmpty()
    @IsString()
    @ApiProperty({
        type: String,
        description: 'User password',
        example: '123456'
    })
    password: string;

    @IsNotEmpty()
    @IsDate()
    @ApiProperty({
        type: Date,
        description: 'User birthday',
        example: '1990-01-01'
    })
    birthday: Date;


    /* Disabled because is in another endpoint (check UpdateUserBalanceDto) for securence */
    // @IsNotEmpty()
    // @IsNumber()
    // @ApiProperty({
    //     type: Number,
    //     description: 'User balance',
    //     example: 1000.00
    // })
    // balance: number;
}

export class UpdateUserBalanceDto {
    @IsNotEmpty()
    @IsDecimal()
    @ApiProperty({
        type: Number,
        description: 'User balance, the number cannot be negative',
        example: 1000
    })
    balance: number;
}