import { AddTransactionModel, Transaction } from '../../models';

export interface AddTransaction {
    add: (params: AddTransaction.Params) => Promise<AddTransaction.Result>
}

export namespace AddTransaction {
    export type Params = AddTransactionModel;
    export type Result = Transaction;
}