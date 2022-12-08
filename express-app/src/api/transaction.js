const { Router } = require("express");
const { User, Transaction, sequelize } = require("../models/index");
const transaction_api = new Router();


transaction_api.get("/api/transaction", async (req, res) => {
    try {
        const { userID, pageEnd, pageStart } = req.query;

        // Valid required params
        if (!userID) {
            return res.status(400).json({
                message: "Query Param [userID] is required in your request!",
                status: 400
            });
        }

        // Check User exist
        const user = await User.findByPk(userID);
        if (!user) {
            return res.status(404).json({ message: "User not found with this Id!", status: 404 });
        }

        // Fetch Transactions from a user
        // Using rules of pagination with the query params [pageStart, pageEnd]
        // If user don't send query params [pageStart, pageEnd]
        // We set default values [pageStart=0, pageEnd=100]
        const transactions = await user.getTransactions({
            order: [
                ["id", "DESC"]
            ],
            offset: pageStart ? Number(pageStart) : 0,
            limit: pageEnd ? Number(pageEnd) : 100
        });
        return res.status(200).json({
            data: {
                "user": user,
                "transactions": transactions
            },
            status: 200
        });
    } catch (error) {
        return res.status(503).json({ message: String(error), status: 503 });
    }
});

transaction_api.post("/api/transaction", async (req, res) => {
    try {
        const { userID, operation_type, amount, comment } = req.body;
        if (!userID || !operation_type || !amount) {
            return res.status(400).json({
                message: "Fields is required in your request body request: [userID, operation_type, amount]",
                status: 400
            });
        }

        // Check operation is ["DÉBITO", "CRÉDITO", "ESTORNO"]
        const defaultOperationType = { "DÉBITO": 0, "CRÉDITO": 1, "ESTORNO": 2 };
        if (!(operation_type in defaultOperationType)) {
            return res.status(400).json({
                message: "Param [operation_type] is invalid, allowed values: [DÉBITO, CRÉDITO, ESTORNO]",
                status: 400
            });
        }

        // Check User exist
        const transaction = await sequelize.transaction();
        let user = await User.findByPk(userID);
        if (!user) {
            return res.status(404).json({ message: "User not found with this Id!", status: 404 });
        }

        // Insert data on DataBase
        try {
            let shortDate = new Date().toISOString().slice(0, 7).replace("-", "/").split("/").reverse().join("/");

            // Create Transaction
            const newTransaction = await Transaction.create({
                operation_type: operation_type,
                amount: amount,
                short_date: shortDate,
                comment: comment,
                user_id: user.id
            });

            // Update user balance
            if (operation_type === "DÉBITO") {
                user.balance = (Number(user.balance) + (-Math.abs(Number(amount))));
            } else {
                user.balance = (Number(user.balance) + (+Math.abs(Number(amount))));
            }
            user.save();
            await transaction.commit();
            return res.status(201).json({
                message: "Transaction created with successfully!",
                data: {
                    "user": user,
                    "transaction": newTransaction
                },
                status: 201
            });

        } catch (error) {
            await transaction.rollback();
            return res.status(500).json({ message: "Database insert error: " + error, status: 500 });
        }
    } catch (error) {
        return res.status(503).json({ message: String(error), status: 503 });
    }
});

transaction_api.put("/api/transaction", async (req, res) => {
    try {
        return res.status(501).json({ message: "501 Not Implemented", status: 501 });
    } catch (error) {
        return res.status(503).json({ message: String(error), status: 503 });
    }
});

transaction_api.delete("/api/transaction", async (req, res) => {
    try {
        const { comment, userID,  transactionID} = req.body;

        // Check field comment in request body
        if (!comment || !userID || !transactionID) {
            return res.status(400).json({
                message: "Field is required in your request body request: [comment, userID, transactionID]",
                status: 400
            });
        }

        // Check User exist
        const user = await User.findByPk(userID);
        const _transaction = await sequelize.transaction();
        if (!user) {
            return res.status(404).json({
                message: "User not found with this Id!",
                status: 404
            });
        }

        // Check Transaction exist
        const transaction = await Transaction.findByPk(transactionID);
        if (!transaction) {
            return res.status(404).json({ message: "Transaction not found with this Id!", status: 404 });
        }

        // Verify if transaction has already been deleted
        if (transaction.deleted) {
            return res.status(410).json({
                message: "Transaction has already been deleted, because: " + transaction.comment,
                status: 410
            });
        }

        // Check Transaction is from user
        if (transaction.user_id != userID) {
            return res.status(400).json({ message: "Transaction is not from this user!", status: 400 });
        }

        // Delete from Database
        try {
            // Update user balance
            if (transaction.operation_type === "DÉBITO") {
                user.balance = (Number(user.balance) + (+Math.abs(Number(transaction.amount))));
            } else {
                user.balance = (Number(user.balance) + (-Math.abs(Number(transaction.amount))));
            }
            transaction.comment = comment;
            transaction.deleted = true;
            transaction.save();
            user.save();
            await _transaction.commit();
            return res.status(410).json({
                message: "Transaction deleted with successfully!",
                data: {
                    "user": user,
                    "transaction": transaction
                },
                status: 410
            });
        } catch (error) {
            await _transaction.rollback();
            return res.status(500).json({ message: "Database delete error: " + error, status: 500 });
        }
    } catch (error) {
        return res.status(503).json({ message: String(error), status: 503 });
    }
});

module.exports = transaction_api;
