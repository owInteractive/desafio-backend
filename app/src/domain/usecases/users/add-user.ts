import { AddUserModel, User } from '../../models';

export interface AddUser {
    add: (params: AddUser.Params) => Promise<AddUser.Result>
}

/**
 * Namespace to hold all types used by AddUser use case.
 * Here we declare all types used by AddUser use case, like the params and the result.
 */
export namespace AddUser {
    export type Params = AddUserModel;
    export type Result = User;
}