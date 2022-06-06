import {
  BadRequestException,
  HttpCode,
  HttpException,
  HttpStatus,
  Injectable,
  NotFoundException,
} from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository, TypeORMError } from 'typeorm';
import { SystemUser } from '../entity/system-user.entity';

@Injectable()
export class SystemUsersService {
  constructor(
    @InjectRepository(SystemUser)
    private readonly systemUserRepository: Repository<SystemUser>,
  ) {}

  async findAll(): Promise<SystemUser[]> {
    return await this.systemUserRepository.find({
      order: {
        createdAt: 'DESC',
      },
      select: ['id', 'login', 'password', 'createdAt', 'updatedAt'],
    });
  }

  async findOne(login: string): Promise<SystemUser> {
    try {
      return await this.systemUserRepository.findOneOrFail({
        where: { login: login },
      });
    } catch (error) {
      throw new NotFoundException();
    }
  }

  async create(systemUser: SystemUser): Promise<SystemUser> {
    try {
      const newSystemUser = await this.systemUserRepository.save(systemUser);
      return newSystemUser;
    } catch (error) {
      throw new BadRequestException(error.message);
    }
  }
}
