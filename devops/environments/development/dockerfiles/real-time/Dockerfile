FROM node:10

WORKDIR /app

COPY package.json /app
RUN npm install

ENTRYPOINT ["/app/node_modules/.bin/laravel-echo-server", "start"]