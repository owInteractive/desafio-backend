import { User } from '../../models';

export interface LoadUsersById {
    loadById (params: LoadUsersById.Params): Promise<LoadUsersById.Result>
}

export namespace LoadUsersById {
    export type Params = {
        userId: string | number;
    };

   
    export type Result = User;
}