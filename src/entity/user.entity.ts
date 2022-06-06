import {
  Column,
  CreateDateColumn,
  DeleteDateColumn,
  Entity,
  OneToMany,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import { Transaction } from './transaction.entity';

@Entity({ name: 'user' })
export class User {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @Column({ type: 'varchar', length: 255, nullable: false })
  name: string;

  @Column({ type: 'tinyint', width: 3, nullable: false })
  age: number;

  @Column({type:'double', default:0, name: 'opening_balance'})
  openingBalance: number;

  @Column({ type: 'varchar', length: 255, nullable: false, unique: true })
  email: string;

  @Column({ type: 'date' })
  birthday: Date;

  @OneToMany(type => Transaction, transaction => transaction.user) 
  transactions: Transaction[];

  @CreateDateColumn({ type: 'datetime', name: 'created_at' })
  createdAt: Date;

  @UpdateDateColumn({ type: 'datetime', name: 'updated_at' })
  updatedAt: Date;

  @DeleteDateColumn({ type: 'datetime', name: 'deleted_at' })
  deletedAt: Date;
}
