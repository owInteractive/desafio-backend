import { User } from "./user";

export type AddTransactionModel = {
  description?: string;
  amount: number;
  type: "debt" | "credit" | "chargeback";
  chargebackFrom?: number;
  from: number;
  to: number;
  createdAt?: Date;
}

export type Transaction = {
  id: number;
  description?: string;
  amount: number;
  type: "debt" | "credit" | "chargeback";
  /**
   * The transaction that was charged back.
   * This field is only present when the transaction is a chargeback.
   */
  chargebackFrom?: Transaction;
  from: User;
  to: User;
  createdAt?: Date;
}