const { Router } = require("express");
const { Op } = require("sequelize");
const { User, Transaction, sequelize } = require("../models/index");
const { exportCsvUserBalance } = require("../utils/index");
const reports_api = new Router();

reports_api.get("/api/report/user/transaction/detail/dataset/csv", async (req, res) => {
    try {
        const { todo, shortDate, lastMonth, userID } = req.query;

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

        // Get transactions of user
        let transactions = Object;
        if (shortDate && !lastMonth && !todo) { // Fetch translations of user by short date. ex: 12/2022
            transactions = await user.getTransactions({
                where: {
                    short_date: shortDate
                },
                order: [
                    ["id", "DESC"]
                ]
            });
        }

        if (lastMonth && !shortDate && !todo) { // Fetch translations of user by last 30 days
            const now = new Date();
            let last30Days = now.setDate(now.getDate() - 30);
            last30Days = new Date(last30Days);
            last30Days = last30Days.toISOString().split("T")[0] + " 00:00:00";
            transactions = await user.getTransactions({
                where: {
                    created_at: {
                        [Op.gte]: last30Days
                    }
                },
                order: [
                    ["id", "DESC"]
                ]
            });
        }

        if (String(todo) == "true" && !lastMonth && !shortDate) { // Fetch TODO translations of user
            transactions = await user.getTransactions({
                order: [
                    ["id", "DESC"]
                ]
            });
        }

        if (transactions === Object) { // Return bad request because query param not was matching
            return res.status(400).json({
                message: "Query Param not matching! Please use this params: *[userID] and [todo=true or lastMonth=true or shortDate=mm/yyyy]",
                status: 400
            });
        }

        // Create string to CSV
        // Separated by Comma and String delemiter "
        let userCSV = await exportCsvUserBalance(user.dataValues, transactions);
        return res.status(200).attachment("userBalance.csv").send(userCSV);
    } catch (error) {
        return res.status(503).json({ message: String(error), status: 503 });
    }
});

reports_api.get("/api/report/user/transaction/balance/dataset/json", async (req, res) => {
    try {
        const { userID } = req.query;

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
            return res.status(404).json({
                message: "User not found with this Id!",
                status: 404
            });
        }

        // Fetch and Sum all transactions from user when is not deleted transaction
        const transactions = await user.getTransactions({
            attributes: [
                "operation_type",
                [sequelize.fn("sum", sequelize.col("amount")), "total_amount"],
            ],
            where: {
                deleted: false
            },
            group: "operation_type"
        });

        // Fetch first transaction by user to get start account balance
        const firstTransactionByUser = await Transaction.findOne({
            where: {
                user_id: user.id
            },
            order: [
                ["id", "ASC"]
            ]
        });

        return res.status(200).json({
            data: {
                "user": {
                    "id": user.id,
                    "name": user.name,
                    "email": user.email,
                    "start_balance": firstTransactionByUser.amount,
                    "current_balance": user.balance
                },
                "total_amount_by_transaction": transactions
            },
            status: 200
        });
    } catch (error) {
        return res.status(503).json({ message: String(error), status: 503 });
    }
});

module.exports = reports_api;
