import { User } from "./user";

export type Transaction = {
  id?: number | string;
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