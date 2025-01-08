FROM php:8.2-fpm

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y \
    locales

RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN pecl install xdebug-3.2.0 && docker-php-ext-enable xdebug

COPY _docker/php/conf.d/* $PHP_INI_DIR/conf.d/

EXPOSE 9000

CMD ["php-fpm"]
