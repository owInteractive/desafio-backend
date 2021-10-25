import { HttpContextContract } from '@ioc:Adonis/Core/HttpContext'
import User from 'App/Models/User'

export default class UsersController {
  public async index({}: HttpContextContract) {
    const users = await User.all()

    return users
  }

  public async store({ request }: HttpContextContract) {
    const data = request.only(['name', 'email', 'birthday', 'password'])

    const user = await User.create(data)

    return user
  }

  public async show({ params }: HttpContextContract) {
    return await User.find(params.id)
  }

  public async destroy({ params }: HttpContextContract) {
    const user = await User.findOrFail(params.id)

    if(user.openingBalance !== null) {
      await user.delete()
    }

    return {
      message: 'user deleted!',
    }
  }

  public async balance({ params, request }) {
    const user = await User.find(params.id)

    user.openingBalance = request.only(['money'])

    await user?.save()

    return user?.openingBalance
  }
}
