import { CanActivate, ExecutionContext, Injectable, UnauthorizedException } from '@nestjs/common';
import { Observable } from 'rxjs';
import { AuthService } from './auth.service';

@Injectable()
export class AuthGuard implements CanActivate {
    constructor(private authService: AuthService) { }

    canActivate(
        context: ExecutionContext,
    ): boolean | Promise<boolean> | Observable<boolean> {
        const { headers } = context.switchToHttp().getRequest();
        if (headers.authorization && headers.authorization.trim()) {
            const verified = this.authService.validateToken(headers.authorization);

            return verified;
        }

        throw new UnauthorizedException('Token not provided');
    }
}
