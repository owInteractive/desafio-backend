export type User = {
    id?: number;
    name: string;
    email: string;
    brithDay: Date;
    role: string;
    password: string
    createdAt?: Date;
    updatedAt?: Date;
}