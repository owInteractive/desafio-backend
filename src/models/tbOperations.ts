import { Model, Table, Column, DataType, Index, Sequelize, ForeignKey } from "sequelize-typescript";

export interface tbOperationsAttributes {
    id?: number;
    typeOperation?: string;
    createdAt?: Date;
    updatedAt?: Date;
}

@Table({ tableName: "tb_operations", timestamps: true })
export class tbOperations extends Model<tbOperationsAttributes, tbOperationsAttributes> implements tbOperationsAttributes {
    @Column({ primaryKey: true, autoIncrement: true, type: DataType.INTEGER })
    @Index({ name: "PRIMARY", using: "BTREE", order: "ASC", unique: true })
      id?: number;

    @Column({ allowNull: true, type: DataType.STRING(255) })
      typeOperation?: string;

    @Column({ type: DataType.DATE })
      createdAt!: Date;

    @Column({ type: DataType.DATE })
      updatedAt!: Date;
}