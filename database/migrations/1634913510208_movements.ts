import BaseSchema from '@ioc:Adonis/Lucid/Schema'

export default class Movements extends BaseSchema {
  protected tableName = 'movements'

  public async up () {
    this.schema.createTable(this.tableName, (table) => {
      table.increments('id')
      table.integer('user_id')
        .unsigned()
        .references('users.id')
        .onDelete('CASCADE')
        .onUpdate('CASCADE')
      table.enu('type', ['DEBIT', 'CREDIT', 'REVERSAL'])
      table.float('value')

      /**
       * Uses timestamptz for PostgreSQL and DATETIME2 for MSSQL
       */
      table.timestamp('created_at', { useTz: true })
      table.timestamp('updated_at', { useTz: true })
    })
  }

  public async down () {
    this.schema.dropTable(this.tableName)
  }
}
