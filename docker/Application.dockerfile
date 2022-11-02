FROM node:18

WORKDIR /usr/src/app

COPY /app/build/ /usr/src/app

RUN npm install --production

ENV PORT=4000
ENV HOST=0.0.0.0
ENV NODE_ENV=production
ENV APP_KEY=0BmWXx0158JiiQzByJd8cpznXqsXTSIT
ENV DRIVE_DISK=local
ENV REDIS_CONNECTION=local
ENV REDIS_HOST=127.0.0.1
ENV REDIS_PORT=6379
ENV REDIS_PASSWORD=owpass

EXPOSE 4000
CMD [ "node", "server.js" ]