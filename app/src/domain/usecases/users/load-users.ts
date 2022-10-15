import { User } from '../../models';

export interface LoadUsers {
    /**
     * Load all users from database.
     */
    load (params?: LoadUsers.Params): Promise<LoadUsers.Result>
}

/**
 * Namespace to hold all types used by LoadUsers use case.
 * Here we declare all types used by LoadUsers use case, like the params and the result.
 */
export namespace LoadUsers {
    export type Params = {
        order?: 'asc' | 'desc';
    };

   
    export type Result = User[];
}