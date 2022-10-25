import { BadRequestException, ConflictException, ForbiddenException, Injectable, NotFoundException, UnauthorizedException } from "@nestjs/common";
import { JwtService } from "@nestjs/jwt";
import { EncodedDTO } from "../user/dto/encoded.dto";
import { UserService } from "../user/user.service";

@Injectable()
export class AuthService {

    constructor(
        private readonly jwtService: JwtService,
        private readonly userService: UserService,
    ) { }

    async login(email: string, password: string) {
        const user = await this.userService.findByEmail(email);
        if (user && await user.validatePassword(password)) {
            const token = this.encodeToken(user)
            return {token};
        }
        return null;
    }

    public validateToken(token: string) {
        if (token) {
            return this.jwtService.verify(token);
        }
        throw new UnauthorizedException('Token not provided');
    }

    public decodeToken(token: string) {
        if (token) {
            return this.jwtService.decode(token);
        }
        throw new UnauthorizedException('Token not provided');
    }

    private encodeToken(userData: EncodedDTO) {
        return this.jwtService.sign({ ...userData })
    }
}