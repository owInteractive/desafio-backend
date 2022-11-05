import type { HttpContextContract } from '@ioc:Adonis/Core/HttpContext'
import User from '../../Models/User'
import { schema } from '@ioc:Adonis/Core/Validator'
import Transaction from 'App/Models/Transaction'

export default class UsersController {
    public async get(ctx: HttpContextContract) {
        ctx.response.status(200)
        return User.query().orderBy('created_at','desc')
    }

    public async post(ctx: HttpContextContract) {
        const rules = schema.create({
            name: schema.string(),
            email: schema.string(),
            birthday: schema.date(),
            balance: schema.number()
        })
        const payload = await ctx.request.validate({ schema: rules })

        if (Math.abs(payload.birthday.diffNow('years').years) >= 18) {
            User.create(payload)
            ctx.response.status(201)
        } else {
            ctx.response.send({
                error: "The user needs to be at least 18 years old"
            })
            ctx.response.status(422)
        }
    }

    public async put(ctx: HttpContextContract) {
        const rules = schema.create({
            user_id: schema.number(),
            balance: schema.number()
        })
        const payload = await ctx.request.validate({ schema: rules })
        
        let result: User
        try {
            result = await User.findByOrFail('id',payload.user_id)
        } catch (error) {
            ctx.response.send({
                error: error.code
            })
            ctx.response.status(404)
            return
        }

        result.balance = payload.balance
        result.save()
        ctx.response.status(200)
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
        } catch (error) {
            ctx.response.send({
                error: error.code
            })
            ctx.response.status(404)
            return
        }

        if (result.balance == 0 && (await Transaction.query().where('user_id','=',result.id)).length == 0) {
            await result.delete()
            ctx.response.status(200)
        }else {
            ctx.response.send({
                error: "User can't be removed because it have transactions or balance linked to his account"
            })
            ctx.response.status(422)
        }
    }
}
