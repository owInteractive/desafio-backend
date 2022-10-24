import { Controller, Get } from '@nestjs/common';
import { ApiOkResponse } from '@nestjs/swagger';
import { AppService } from './app.service';

@Controller()
export class AppController {
  constructor(private readonly appService: AppService) { }

  @Get()
  @ApiOkResponse({ description: 'Return a default status API running' })
  getApi(): string {
    return this.appService.getApi();
  }
}
