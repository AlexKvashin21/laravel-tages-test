FROM node:20-slim

WORKDIR /var/www/laravel

COPY ./package.json .
COPY ./package-lock.json .

RUN npm install

COPY . .
