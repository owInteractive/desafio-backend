import { Model, Table, Column, DataType, Index, Sequelize, ForeignKey } from "sequelize-typescript";

export interface tbUsersAttributes {
    id?: number;
    name?: string;
    email?: string;
    birthday?: string;
    initialValue?: string;
    createdAt?: Date;
    updatedAt?: Date;
}

@Table({ tableName: "tb_users", timestamps: true })
export class tbUsers extends Model<tbUsersAttributes, tbUsersAttributes> implements tbUsersAttributes {
    @Column({ primaryKey: true, autoIncrement: true, type: DataType.INTEGER })
    @Index({ name: "PRIMARY", using: "BTREE", order: "ASC", unique: true })
      id?: number;

    @Column({ allowNull: true, type: DataType.STRING(255) })
      name?: string;

    @Column({ allowNull: true, type: DataType.STRING(255) })
      email?: string;

    @Column({ allowNull: true, type: DataType.DATEONLY })
      birthday?: string;

    @Column({ allowNull: true, type: DataType.STRING(10) })
      initialValue?: string;

    @Column({ type: DataType.DATE })
      createdAt!: Date;

    @Column({ type: DataType.DATE })
      updatedAt?: Date;
}