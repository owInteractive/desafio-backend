import {
  BeforeInsert,
  Column,
  CreateDateColumn,
  DeleteDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  UpdateDateColumn,
} from 'typeorm';
import { hashSync } from 'bcrypt';

@Entity({ name: 'systemUser' })
export class SystemUser {
  @PrimaryGeneratedColumn('uuid')
  id: string;

  @Column({ nullable: false, unique: true })
  login: string;

  @Column({ nullable: false })
  password: string;
  @CreateDateColumn({ type: 'datetime', name: 'created_at' })
  createdAt: string;
  @UpdateDateColumn({ type: 'datetime', name: 'updated_at' })
  updatedAt: string;
  @DeleteDateColumn({ type: 'datetime', name: 'deleted_at' })
  deletedAt: string;

  @BeforeInsert()
  hashPassword() {
    this.password = hashSync(this.password, 10);
  }
}
