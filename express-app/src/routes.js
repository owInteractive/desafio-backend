const { Router } = require("express");
const routes = new Router();


routes.get("*", (req, res) => {
    try {
        res.status(404).json({
            message: "The server cannot find the requested resource.",
            status: 404
        });
    } catch (error) {
        res.status(503).json({
            message: String(error),
            status: 503
        });
    }
});

module.exports = routes;
