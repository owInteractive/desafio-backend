import { AddUserController } from '@/presentation/controllers/users-controller';
import { Controller } from '@/presentation/protocols';
import { makeDbAddUser, makeDbLoadUsersByEmail } from '../../usecases/user';

export function makeAddUserController(): Controller {
    return new AddUserController(makeDbAddUser(), makeDbLoadUsersByEmail());
}