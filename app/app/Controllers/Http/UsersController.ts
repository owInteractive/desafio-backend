import type { HttpContextContract } from '@ioc:Adonis/Core/HttpContext'
import User from '../../Models/User'
import { schema } from '@ioc:Adonis/Core/Validator'

export default class UsersController {
    public async get(ctx: HttpContextContract) {
        ctx.response.status(201)
        return User.query().orderBy('created_at','desc')
    }

    public async post(ctx: HttpContextContract) {
        if (!ctx.request.hasBody()) ctx.response.status(500)
        const rules = schema.create({
            name: schema.string(),
            email: schema.string(),
            birthday: schema.date(),
        })
        const payload = await ctx.request.validate({ schema: rules })
        User.create(payload)
        ctx.response.status(201)
    }

    public async getById(ctx: HttpContextContract) {
        let result: User
        try {
            result = await User.findByOrFail('id',ctx.request.params().id)
        } catch (error) {
            ctx.response.send({
                error: error.code
            })
            ctx.response.status(404)
            return
        }
        ctx.response.status(200)
        return result
    }

    public async delete(ctx: HttpContextContract) {
        let result: User
        try {
            result = await User.findByOrFail('id',ctx.request.params().id)
            await result.delete()
        } catch (error) {
            ctx.response.send({
                error: error.code
            })
            ctx.response.status(404)
            return
        }
        ctx.response.status(200)
        return result
    }
}
