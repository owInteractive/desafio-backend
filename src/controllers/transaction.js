const kenx = require('../database/connect');
const { createArrayCsvWriter } = require('csv-writer');

async function createTransaction(req, res) {

    const { user } = req;
    const { type, amount, description } = req.body;

    try {

        const newTransactionId = await kenx('transactions').insert({ user_id: user.id, type, amount, description, moment: new Date() });

        const transaction = await kenx('transactions').where({ id: newTransactionId }).first();

        return res.status(201).json(transaction);

    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function getTransactionsByUser(req, res) {

    const { user } = req;
    const { page } = req.query;

    const limit_value = 5;
    const offset_value = page ? page * limit_value : 0;

    try {
        const transactions = await kenx('transactions').where({ user_id: user.id }).orderBy('moment', 'desc').limit(limit_value).offset(offset_value);

        user.page = page ? Number(page) : 0;
        user.transactions = transactions


        return res.status(200).json(user);
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function deleteTransaction(req, res) {

    const { transaction } = req;

    try {
        await kenx('transactions').where({ id: transaction.id }).delete();

        return res.status(200).json({ message: 'Transação excluida com sucesso!' });
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function getTransactionsCSV(req, res) {
    const { transactions } = req;

    try {

        const header = Object.getOwnPropertyNames(transactions[0]);
        const path = `./src/temp/${new Date().getTime()}.csv`

        const csvWriter = createArrayCsvWriter({
            path,
            header: [...header]
        });


        let records = [];

        for (const transaction of transactions) {
            records.push(Object.values(transaction));
        }

        await csvWriter.writeRecords(records);

        return res.download(path);
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }
}

async function getTransactionsSummary(req, res) {
    const { user } = req;

    try {
        const transactions = await kenx('transactions').where({ user_id: user.id });

        const transactions_summary = {
            opening_balance: user.opening_balance,
            debit: 0,
            credit: 0,
            reversal: 0
        }

        transactions.forEach(transaction => {
            if (transaction.type === 'debit') {
                transactions_summary.debit += transaction.amount;
            }
            else if (transaction.type === 'credit') {
                transactions_summary.credit += transaction.amount;
            }
            else if (transaction.type === 'reversal') {
                transactions_summary.reversal += transaction.amount;
            }
        });

        return res.status(200).json(transactions_summary);
    } catch (error) {
        return res.status(500).json({ error: error.message });
    }

}

module.exports = {
    createTransaction,
    getTransactionsByUser,
    deleteTransaction,
    getTransactionsCSV,
    getTransactionsSummary
}