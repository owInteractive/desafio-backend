import {
    Entity,
    Column,
    CreateDateColumn,
    UpdateDateColumn,
    PrimaryGeneratedColumn,
  } from "typeorm";
  
  @Entity("usuarios")
  class User {
    @PrimaryGeneratedColumn()
    readonly id!: number;
  
    @Column()
    name!: string;
  
    @Column()
    email!: string;
    
    @Column()
    birthday!: Date;
  
    @CreateDateColumn()
    created_at!: Date;
  
    @UpdateDateColumn()
    updated_at!: Date;
  }
  
  export { User };
