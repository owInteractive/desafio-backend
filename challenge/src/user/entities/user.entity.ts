import { Transaction } from '../../transactions/entities/transaction.entity';
import { Entity, Column, PrimaryGeneratedColumn, CreateDateColumn, UpdateDateColumn, OneToMany, BeforeInsert, BaseEntity } from 'typeorm';
import * as bcrypt from 'bcrypt';

@Entity()
export class User extends BaseEntity {
    @PrimaryGeneratedColumn()
    id: number;

    @Column({ length: 200 })
    name: string;

    @Column({ length: 150, unique: true })
    email: string;

    @Column({})
    password: string;

    @Column({ type: 'date', nullable: false })
    birthday: Date;

    @Column({ type: 'numeric', precision: 10, scale: 2, default: () => '0.00' })
    balance: number;

    @OneToMany(() => Transaction, transaction => transaction.user)
    public transactions: Transaction[];

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    @CreateDateColumn()
    createdAt: Date;

    @Column({ type: 'datetime', default: () => 'CURRENT_TIMESTAMP' })
    @UpdateDateColumn()
    updatedAt: Date;

    @BeforeInsert()
    async hashPassword() {
        this.password = await bcrypt.hash(this.password, 10);
    }

    async validatePassword(password: string): Promise<boolean> {
        return await bcrypt.compare(password, this.password);
    }
}