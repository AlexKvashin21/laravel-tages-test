FROM node:20.8.0

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y \
    vim \
    zip \
    unzip \
    curl

COPY ./package.json .
COPY ./package-lock.json .

RUN npm install

COPY . .
