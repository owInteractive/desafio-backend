import { SystemUsersService } from './../system-users/system-users.service';
import { Injectable } from '@nestjs/common';
import { SystemUser } from 'src/entity/system-user.entity';
import { compareSync } from 'bcrypt';
import { JwtService } from '@nestjs/jwt';

@Injectable()
export class AuthService {
  constructor(
    private readonly systemUsersService: SystemUsersService,
    private readonly jwtService: JwtService,
  ) {}

  async login(systemUser: SystemUser) {
    const payload = { sub: systemUser.id, login: systemUser.login };

    return {
      token: this.jwtService.sign(payload),
    };
  }

  async validateUser(login: string, password: string) {
    let systemUser: SystemUser;
    try {
      systemUser = await this.systemUsersService.findOne(login);
    } catch (error) {
      return false;
    }

    const isValidLogin = compareSync(password, systemUser.password);
    if (!isValidLogin && systemUser.password != password) return false;
    return systemUser;
  }
}
