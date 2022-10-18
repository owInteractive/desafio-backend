import { Transaction } from "./transactions";

export type User = {
    id?: number;
    name: string;
    email: string;
    birthDay: Date | string;
    role?: string
    password: string
    transactions?: Transaction[]
    createdAt?: Date;
    updatedAt?: Date;
}