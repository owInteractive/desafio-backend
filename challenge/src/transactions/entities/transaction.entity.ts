import { Entity, Column, PrimaryGeneratedColumn } from 'typeorm';

export enum TransactionType {
    credit = 'credit',
    debit = 'debit',
    reversal = 'reversal',
  }

@Entity()
export class Transaction {
    @PrimaryGeneratedColumn()
    id: number;

    @Column({ type: 'int', nullable: false })
    userId: number;

    @Column({ type: 'decimal', precision: 10, scale: 2, default: () => '0.00' })
    value: number;

    @Column({ nullable: false })
    description: string;

    @Column({ type: 'enum', enum: TransactionType, default: 'credit' })
    type: string;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    createdAt: Date;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    updatedAt: Date;
}

