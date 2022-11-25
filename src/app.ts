require('dotenv').config();
import dotenv from 'dotenv';
dotenv.config();

import express from 'express';
import routes from './routes';

import morgan from 'morgan';

import compression from 'compression';
import helmet from 'helmet';

morgan(':method :url :status :res[content-length] - :response-time ms');

const app = express();

app.use(morgan('tiny'));
app.use(express.json());
app.use(express.json({ limit: '20mb' }));

app.use(routes);
app.use(compression);
app.use(helmet);

app.disable('x-powered-by');

const PORT = process.env.PORT || 3050;

const http = require('http');
const httpServer = http.createServer(app);

httpServer.listen(PORT, () => {
  console.log(`A aplicação está rodando na porta ${PORT}`);
});

