const { Router } = require("express");
const { User, sequelize } = require("../models/index");
const { validEmail, getAge } = require("../utils/index");
const user_api = new Router();


user_api.get("/api/user", async (req, res) => {
    try {
        let query = {};
        const { userID } = req.query;

        // Check query params
        if (userID) {
            const user = await User.findByPk(userID);

            // If not found user with this id
            if (!user) {
                return res.status(404).json({
                    message: "User not found with this id!",
                    status: 404
                });
            }

            return res.status(200).json({
                data: {
                    "user": user
                },
                status: 200
            });

        }
        // Fetch all users
        let users = await User.findAll({
            order: [
                ["id", "DESC"]
            ]
        });
        return res.status(200).json({
            data: {
                "users": users
            },
            status: 200
        });
    } catch (error) {
        res.json({ message: String(error), status: 503 });
    }
});

user_api.post("/api/user", async (req, res) => {
    try {
        const { name, email, birthday } = req.body;
        // Check required fields in the body of request
        if (!name || !email || !birthday) {
            return res.status(400).json({
                message: "Fields is required in your request body request: [name, email, birthday]",
                status: 400
            });
        }

        // Check if email is valid
        emailIsValid = await validEmail(email);
        if (!emailIsValid) {
            return res.status(400).json({
                message: `E-mail: [${email}] is invalid!`,
                status: 400
            });
        }

        // Have < 18 years old
        const age = getAge(birthday);
        if (age < 18) {
            return res.status(400).json({
                message: "You must be 18 years or older to create an account.",
                status: 400
            });
        }

        // Have >= 130 years old
        if (age >= 130) {
            return res.status(400).json({
                message: "I'm sorry you look very old, you can't validate your age.",
                status: 400
            });
        }

        // Insert Data in DataBase
        try {
            const newUser = await User.create({
                name: name,
                email: email,
                birthday: new Date(birthday).toISOString()
            });

            return res.status(201).json({
                message: "User created with Sucessfully",
                data: {
                    user: newUser
                },
                status: 201
            });

        } catch (error) {
            return res.status(500).json({
                message: "Database insert error: " + error,
                status: 500
            });
        }

    } catch (error) {
        res.status(503).json({
            message: String(error),
            status: 503
        });
    }
});

user_api.put("/api/user", async (req, res) => {
    try {
        res.status(501).json({
            message: "501 Not Implemented",
            status: 501
        });
    } catch (error) {
        res.status(503).json({
            message: String(error),
            status: 503
        });
    }
});

user_api.delete("/api/user", async (req, res) => {
    try {
        const { userID } = req.query;
        // Check query param
        if (!userID) {
            return res.status(400).json({
                message: "Query Param [userID] is required in your request!",
                status: 400
            });
        }

        // Check user
        const user = await User.findByPk(userID);
        if (!user) {
            return res.status(404).json({
                message: "User not found with this id!",
                status: 404
            });
        }

        // Check if user have transactions
        const transactions = await user.getTransactions();
        console.log(transactions);
        if (transactions.length > 0) {
            return res.status(400).json({
                message: "Unable to delete record. There are transactions for the user!",
                status: 400
            });
        }

        try {
            await user.destroy();
            return res.status(410).json({
                message: "User deleted with successfully!",
                status: 410
            });
        } catch (error) {
            return res.status(500).json({
                message: "Database delete error: " + error,
                status: 500
            });
        }


    } catch (error) {
        res.json({
            message: String(error),
            status: 503
        });
    }
});

module.exports = user_api;
