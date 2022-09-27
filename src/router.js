const { Router } = require('express');
const { createTransaction, getTransactionsByUser, deleteTransaction, getTransactionsCSV, getTransactionsSummary } = require('./controllers/transaction');
const { getAllUsers, createUser, getUser, deleteUser, updateUserOpeningBalance } = require('./controllers/user');
const { validateCreateTransaction, verifyTransactionId, transactionsFilter } = require('./middlewares/transaction');
const { verifyUserId, validateCreateUser, validateDeleteUser } = require('./middlewares/user');

const routes = Router();

routes.get('/users', getAllUsers);
routes.post('/user', validateCreateUser, createUser);
routes.get('/user/:user_id', verifyUserId, getUser);
routes.delete('/user/:user_id', verifyUserId, validateDeleteUser, deleteUser);
routes.patch('/user/:user_id', verifyUserId, updateUserOpeningBalance);

routes.post('/transaction/:user_id', validateCreateTransaction, verifyUserId, createTransaction);
routes.get('/transactions/user/:user_id', verifyUserId, getTransactionsByUser);
routes.delete('/transaction/:transaction_id', verifyTransactionId, deleteTransaction);
routes.get('/transactions/user/:user_id/csv', verifyUserId, transactionsFilter, getTransactionsCSV);
routes.get('/transactions/user/:user_id/summary', verifyUserId, getTransactionsSummary);

module.exports = routes;