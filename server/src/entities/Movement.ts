import {
    Entity,
    PrimaryColumn,
    Column,
    JoinColumn,
    ManyToOne,
    CreateDateColumn,
    UpdateDateColumn,
    PrimaryGeneratedColumn,
  } from "typeorm";
import { User } from "./User";

  export type Operations = 'debito' | 'credito' | 'estorno'
  
  @Entity("movimentacoes")
  class Movement {
    @PrimaryGeneratedColumn()
    readonly id!: number;
  
    @Column()
    operation!: Operations;

    @Column('float')
    value!: number;
  
    @ManyToOne(() => User, { onDelete:'CASCADE', nullable: true })
    @JoinColumn({ name: 'user_id' })
    user_id!: User;
  
    @CreateDateColumn()
    created_at!: Date;
  
    @UpdateDateColumn()
    updated_at!: Date;
  }
  
  export { Movement };
