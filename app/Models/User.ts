import { DateTime } from 'luxon'
import Hash from '@ioc:Adonis/Core/Hash'
import { column, beforeSave, BaseModel, hasMany, HasMany } from '@ioc:Adonis/Lucid/Orm'
import Movement from './Movement'

export default class User extends BaseModel {
  @column({ isPrimary: true })
  public id: number

  @hasMany(() => Movement)
  public movement: HasMany<typeof Movement>

  @column()
  public name: string

  @column()
  public email: string

  @column()
  public birthday: DateTime

  @column()
  public openingBalance: number

  @column({ serializeAs: null })
  public password: string

  @column()
  public rememberMeToken?: string

  @column.dateTime({ autoCreate: true })
  public createdAt: DateTime

  @column.dateTime({ autoCreate: true, autoUpdate: true })
  public updatedAt: DateTime

  @beforeSave()
  public static async hashPassword(user: User) {
    if (user.$dirty.password) {
      user.password = await Hash.make(user.password)
    }
  }
}
