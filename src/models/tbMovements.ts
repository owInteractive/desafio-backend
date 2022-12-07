import { Model, Table, Column, DataType, Index, Sequelize, ForeignKey, BelongsTo } from "sequelize-typescript";
import { tbUsers } from "./tbUsers";

export interface tbMovementsAttributes {
    id?: number;
    idUser?: number;
    idTypeOperation?: number;
    valueOperation?: string;
    createdAt?: Date;
    updatedAt?: Date;
}

@Table({ tableName: "tb_movements", timestamps: true })
export class tbMovements extends Model<tbMovementsAttributes, tbMovementsAttributes> implements tbMovementsAttributes {
    @Column({ primaryKey: true, autoIncrement: true, type: DataType.INTEGER })
    @Index({ name: "PRIMARY", using: "BTREE", order: "ASC", unique: true })
      id?: number;

    @ForeignKey(() => tbUsers)
    @Column({ allowNull: true, type: DataType.INTEGER })
      idUser?: number;

    @BelongsTo(() => tbUsers)
      tb_movements!: tbUsers;

    @Column({ allowNull: true, type: DataType.INTEGER })
      idTypeOperation?: number;

    @Column({ allowNull: true, type: DataType.DECIMAL(10) })
      valueOperation?: string;

    @Column({ type: DataType.DATE })
      createdAt!: Date;

    @Column({ type: DataType.DATE })
      updatedAt!: Date;
}