import type { HttpContextContract } from '@ioc:Adonis/Core/HttpContext'
import Transaction from 'App/Models/Transaction'
import User from 'App/Models/User'
import { schema } from '@ioc:Adonis/Core/Validator'

export default class TransactionsController {
    public async get(ctx: HttpContextContract) {
        let transaction, user
        try {
            user = await User.findByOrFail('id',ctx.request.params().user_id)
            if (ctx.request.qs().type) {
                switch (ctx.request.qs().type) {
                    case "credit":
                        transaction = await Transaction.query().where('user_id','=',ctx.request.params().user_id).
                            where('type','=','credit')
                    break
                    case "debt":
                        transaction = await Transaction.query().where('user_id','=',ctx.request.params().user_id).
                            where('type','=','debt')
                    break
                    case "reversal":
                        transaction = await Transaction.query().where('user_id','=',ctx.request.params().user_id).
                            where('type','=','reversal')
                    break
                    default:
                        transaction = await Transaction.query().where('user_id','=',ctx.request.params().user_id)
                    break
                }
            } else {
                transaction = await Transaction.query().where('user_id','=',ctx.request.params().user_id)
            }
        } catch (error) {
            ctx.response.send({
                error: error.code
            })
            ctx.response.status(404)
            return
        }
        ctx.response.send({
            user: user,
            transactions: transaction
        })
        ctx.response.status(200)
    }

    public async post(ctx: HttpContextContract) {
        const rules = schema.create({
            type: schema.enum(['credit','debt','reversal']),
            value: schema.number(),
            user_id: schema.number(),
        })
        const payload = await ctx.request.validate({schema: rules})

        try {
            const user = await User.findByOrFail('id',payload.user_id)
        } catch (error) {
            ctx.response.send({
                error: "User not found"
            })
            ctx.response.status(404)
            return
        }

        Transaction.create(payload)
        ctx.response.status(201)
    }

    public async delete(ctx: HttpContextContract) {
        const payload = await ctx.request.validate({
            schema: schema.create({
                transaction_id: schema.number()
            })
        })

        let result
        try {
            result = await Transaction.findByOrFail('id',payload.transaction_id)
            await result.delete()
        } catch (error) {
            ctx.response.send({
                error: error.code
            })
            ctx.response.status(404)
            return
        }
        ctx.response.status(200)
    }
}
