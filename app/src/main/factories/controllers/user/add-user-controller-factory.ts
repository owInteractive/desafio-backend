import { AddUserController } from '@/presentation/controllers/users-controller';
import { Controller } from '@/presentation/protocols';
import { makeDbAddUser, makeDbLoadUsersByEmail } from '../../usecases/user';
import { makeAddUserControllerValidator } from '../../validators/users/add-user-controller-validator';


export function makeAddUserController(): Controller {
    return new AddUserController(makeDbAddUser(), makeDbLoadUsersByEmail(), makeAddUserControllerValidator());
}