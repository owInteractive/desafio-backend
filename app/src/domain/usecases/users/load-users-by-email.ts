import { User } from '../../models';

export interface LoadUsersByEmail {
    loadByEmail (params: LoadUsersByEmail.Params): Promise<LoadUsersByEmail.Result>
}

export namespace LoadUsersByEmail {
    export type Params = {
        email: string;
    };

   
    export type Result = User;
}