import { PickType } from "@nestjs/mapped-types";
import { User } from "../entities/user.entity";

export class EncodedDTO extends PickType(User, ['id','email','name', 'balance', 'birthday']) {}