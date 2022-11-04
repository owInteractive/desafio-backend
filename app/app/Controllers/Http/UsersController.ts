// import type { HttpContextContract } from '@ioc:Adonis/Core/HttpContext'
import User from '../../Models/User'

export default class UsersController {
    public async index() {
       return User.all()
    }
}
