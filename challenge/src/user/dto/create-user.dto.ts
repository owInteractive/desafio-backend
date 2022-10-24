import { ApiProperty } from '@nestjs/swagger';
import { IsEmail, IsNotEmpty, IsString, IsDate } from 'class-validator';

export class CreateUserDto {
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
    @IsDate()
    @ApiProperty({
        type: Date,
        description: 'User birthday',
        example: '1990-01-01'
    })
    birthday: Date;
}