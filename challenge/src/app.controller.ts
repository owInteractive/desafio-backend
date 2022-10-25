import { Controller, Request, Get, Post, UseGuards, Body } from '@nestjs/common';
import { AuthGuard } from './auth/auth.guard';
import { ApiOkResponse, ApiTags } from '@nestjs/swagger';
import { AppService } from './app.service';
import { AuthService } from './auth/auth.service';
import { LoginUserDto } from './user/dto/login-user.dto';

@ApiTags('Auth')
@Controller()
export class AppController {
  constructor(private readonly appService: AppService, private readonly authService: AuthService) { }

  @Post('auth/login')
  async login(@Body() user: LoginUserDto) {
    return await this.authService.login(user.email, user.password);
  }

  // @UseGuards(AuthGuard)
  // @Get('auth/login')
  // @ApiOkResponse({ description: 'Get user profile' })
  // getProfile() {
  //   return 'req.user';
  // }
}
