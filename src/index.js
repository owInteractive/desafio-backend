require('dotenv').config();
const cors = require('cors');
const express = require('express');
const routes = require('./router');

console.log(process.env.DATABASE_HOST);
const app = express();

app.use(express.json());
app.use(routes);
app.use(cors());

const port = 3000;

app.listen(port, () => { console.log(`Started server in port ${port}`); })