const { subDays, format } = require('date-fns');
const knex = require('../database/connect');
const { schemaCreateTransaction } = require('../validations/schemaTransaction');

async function validateCreateTransaction(req, res, next) {
    const { type } = req.body;

    if (type !== 'debit' && type !== 'credit' && type !== 'reversal') {
        return res.status(400).json({ error: 'Type incorreto. O campo type tem as seguintes opções: debit, credit ou reversal' });
    }
    try {
        await schemaCreateTransaction.validate(req.body);
        return next();
    } catch (error) {
        return res.status(400).json({ error: error.message });
    }
}

async function verifyTransactionId(req, res, next) {

    const { transaction_id } = req.params;

    try {
        const transaction = await knex('transactions').where({ id: transaction_id }).first();

        if (!transaction) {
            return res.status(404).json({ error: `Transação inexistente!` });
        }

        req.transaction = transaction;

        return next();
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function transactionsFilter(req, res, next) {

    try {
        const { user } = req;
        const { last_days, month_year } = req.query;

        const transactions = await knex('transactions').where({ user_id: user.id }).orderBy('moment', 'desc');

        if (last_days) {
            const dateDifferences = subDays(new Date(), last_days);
            const filteredForDay = transactions.filter((transaction) => (
                +new Date(transaction.moment) >= +dateDifferences
            ));
            req.transactions = filteredForDay;
            return next();
        }

        if (month_year) {
            const filteredForMonthAndYear = transactions.filter((transaction) => (
                format(new Date(transaction.moment), 'MM/yy') === month_year
            ));
            req.transactions = filteredForMonthAndYear;
            return next();
        }

        req.transactions = transactions
        return next();
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

module.exports = {
    validateCreateTransaction,
    verifyTransactionId,
    transactionsFilter
}

