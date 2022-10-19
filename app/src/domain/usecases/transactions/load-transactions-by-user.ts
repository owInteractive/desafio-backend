import { Transaction } from "@/domain/models";
import { GetPaginatedParams, Paginated } from "../pagination";

export interface LoadTransactionByUser {
    loadByUser: (params: LoadTransactionByUser.Params) => Promise<LoadTransactionByUser.Result>
}

export namespace LoadTransactionByUser {
    export type Params = {
        userId: number;
    }&GetPaginatedParams;

    export type Result = Paginated<Transaction>;
}