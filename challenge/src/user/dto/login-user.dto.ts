import { ApiProperty } from '@nestjs/swagger';
import { IsEmail, IsNotEmpty, IsString, IsDate } from 'class-validator';

export class LoginUserDto {
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
}