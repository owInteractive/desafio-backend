import { User } from '../../models';

enum UserOrders {
    asc = 'asc',
    desc = 'desc'
}

export interface LoadUsers {
    /**
     * Load all users from database.
     */
    load (params: LoadUsers.Params): Promise<LoadUsers.Result[]>
    /**
     * This method is an overload, it's used to load a single user by id.
     */
    load (params: LoadUsers.ParamsById): Promise<LoadUsers.Result>
}

/**
 * Namespace to hold all types used by LoadUsers use case.
 * Here we declare all types used by LoadUsers use case, like the params and the result.
 */
export namespace LoadUsers {
    export type Params = {
        order?: UserOrders;
    };

    export type ParamsById = {
        id: number;
    };
    export type Result = User;
}