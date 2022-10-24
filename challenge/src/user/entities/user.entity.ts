import { Entity, Column, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class User {
    @PrimaryGeneratedColumn()
    id: number;

    @Column({ length: 200 })
    name: string;

    @Column({ length: 150 })
    email: string;

    @Column({ type: 'datetime' })
    birthday: Date;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    createdAt: Date;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    updatedAt: Date;
}