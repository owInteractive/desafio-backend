const knex = require('../database/connect');
const { schemaUpdateOpeningBalance } = require('../validations/schemaUser');

async function getAllUsers(req, res) {

    try {
        const users = await knex('users').orderBy('created_at', 'desc');
        res.status(200).json(users);
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function createUser(req, res) {

    try {
        const newUser = await knex('users').insert({ ...req.body, created_at: new Date() });

        if (newUser.length === 0) {
            return res.status(400).json({ message: "Erro ao cadastrar usuário. Usuário não foi cadastrado!" })
        }

        res.status(201).json({ message: 'Usuário cadastrado com sucesso!' });

    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function getUser(req, res) {
    const { user } = req;

    try {
        return res.status(200).json(user);
    } catch (error) {
        return res.status(500).json({ error: error.message })
    }
}

async function deleteUser(req, res) {
    const { id } = req.user;
    try {
        await knex('users').where({ id }).delete();
        return res.status(200).json({ message: 'Usuário excluido com sucesso!' });
    } catch (error) {
        return res.status(400).json({ error: error.message })
    }
}

async function updateUserOpeningBalance(req, res) {

    const { user } = req;
    const { opening_balance } = req.body;

    try {
        await schemaUpdateOpeningBalance.validate({ opening_balance });

        await knex('users').where({ id: user.id }).update({ opening_balance, updated_at: new Date() });

        return res.status(200).json({ message: 'Saldo inicial alterado com sucesso!' });
    } catch (error) {
        return res.status(500).json({ error: error.message })
    }
}


module.exports = {
    getAllUsers,
    createUser,
    getUser,
    deleteUser,
    updateUserOpeningBalance
}