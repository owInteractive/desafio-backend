FROM node:lts-alpine3.15
 
WORKDIR /desafio-backend

COPY package.json ./
COPY yarn.lock ./

COPY . .
 
EXPOSE 3050

CMD [ "nodemon", "app.js" ]
