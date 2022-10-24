import { Entity, Column, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class User {
    @PrimaryGeneratedColumn()
    id: number;

    @Column({ length: 200 })
    name: string;

    @Column({ length: 150, unique: true })
    email: string;

    @Column({ length: 255 })
    password: string;

    @Column({ type: 'date', nullable: false })
    birthday: Date;

    @Column({ type: 'decimal', precision: 10, scale: 2, default: () => '0.00' })
    balance: number;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    createdAt: Date;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    updatedAt: Date;
}