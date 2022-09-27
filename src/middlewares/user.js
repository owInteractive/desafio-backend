const { differenceInYears } = require("date-fns");
const knex = require("../database/connect");
const { schemaCreateUser, schemaUpdateOpeningBalance } = require('../validations/schemaUser');


async function validateCreateUser(req, res, next) {
    const { birthday } = req.body;

    if (differenceInYears(new Date(), new Date(birthday)) < 18) {
        return res.status(400).json({ error: 'Usuário precisa ter a idade maior que 18 anos.' });
    }

    try {
        await schemaCreateUser.validate(req.body);

        return next();
    } catch (error) {
        return res.status(400).json({ error: error.message });
    }

}

async function verifyUserId(req, res, next) {

    const { user_id } = req.params;

    try {
        const user = await knex('users').where({ id: user_id }).first();

        if (!user) {
            return res.status(404).json({ error: `Usuário inexistente!` });
        }

        req.user = user;

        return next();
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function validateDeleteUser(req, res, next) {

    const { user } = req;

    if (user.opening_balance !== 0) {
        return res.status(400).json({ error: 'Não é possível excluir usuários com saldo inicial diferente de 0.' })
    }

    try {
        const transactions = await knex('transactions').where({ user_id: user.id });

        if (transactions.length !== 0) {
            return res.status(400).json({ error: 'Não é possível excluir usuários com movimentações vinculadas.' })
        }

        return next();
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

module.exports = {
    verifyUserId,
    validateCreateUser,
    validateDeleteUser
}