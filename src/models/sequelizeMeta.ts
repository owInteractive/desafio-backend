import { Model, Table, Column, DataType, Index, Sequelize, ForeignKey } from "sequelize-typescript";

export interface sequelizeMetaAttributes {
    name: string;
}

@Table({ tableName: "SequelizeMeta", timestamps: false })
export class sequelizeMeta extends Model<sequelizeMetaAttributes, sequelizeMetaAttributes> implements sequelizeMetaAttributes {
    @Column({ primaryKey: true, type: DataType.STRING(255) })
    @Index({ name: "name", using: "BTREE", order: "ASC", unique: true })
    @Index({ name: "PRIMARY", using: "BTREE", order: "ASC", unique: true })
      name!: string;
}