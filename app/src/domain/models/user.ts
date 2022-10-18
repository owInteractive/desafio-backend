export type User = {
    id?: number;
    name: string;
    email: string;
    birthDay: Date;
    role: string;
    password: string
    createdAt?: Date;
    updatedAt?: Date;
}