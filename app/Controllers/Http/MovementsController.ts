import { HttpContextContract } from '@ioc:Adonis/Core/HttpContext'
import Movement from 'App/Models/Movement'
import User from 'App/Models/User'

export default class MovementsController {
  public async store ({ request }: HttpContextContract) {
    let data = request.only(['type', 'value', 'user_id'])

    const movement = await Movement.create(data)

    return movement

  }

  public async show ({ params }: HttpContextContract) {
    const user = await User.find(params.id)
    await user?.load('movement')

    return user
  }


  public async destroy ({ params }: HttpContextContract) {
    const moviment = await Movement.findOrFail(params.id)
    const user = await User.find(params.userId)
    if(user?.id == moviment.userId) {
      await moviment.delete()

      return {
        message: 'moviment deleted!',
      }
    }

    return {
      message: 'moviment not deleted!',
    }
  }
}
