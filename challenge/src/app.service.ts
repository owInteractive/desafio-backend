import { Injectable } from '@nestjs/common';

@Injectable()
export class AppService {
  getApi(): string {
    return 'The API is running!';
  }
}
