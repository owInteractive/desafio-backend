const express = require("express");
const routes = require("./routes");
const user_api = require("./api/user");
const transaction_api = require("./api/transaction");
const reports_api = require("./api/reports");
const { sequelize } = require("./models/index");
const bodyParser = require('body-parser');


// Config Express App
const app = express();
app.use(bodyParser.urlencoded({ extended: false }));
app.use(express.json());

// Register api's
app.use(user_api);
app.use(transaction_api);
app.use(reports_api);

// Register default 404 error to other routes not found
app.use(routes);

// Sync database with sequelize
sequelize.sync().then(() => {
    console.log("Database Connection Successfully!!!");
});

module.exports = app;
