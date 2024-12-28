FROM php:8.2.20-fpm

RUN pecl install redis && docker-php-ext-enable redis

RUN apt-get update && apt-get install -y \
      supervisor \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      nano \
      libwebp-dev \
      libjpeg-dev \
      locales \
      libonig-dev \
      git && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install zip && \
      docker-php-ext-install exif && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring opcache zip
RUN docker-php-ext-enable pdo_mysql zip

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update && apt-get install -y \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev libxpm-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd  --with-jpeg --with-webp --with-freetype

RUN docker-php-ext-install gd

COPY . /var/www/autojobfinder
WORKDIR /var/www/autojobfinder
# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
# alias
RUN echo "alias a='artisan'" >> /root/.bashrc

#RUN apt-get update
#RUN sudo apt-get install -y build-essential
#RUN apt-get install -y npm

# Настройка supervisor
#COPY ./_docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

#ENTRYPOINT composer install \
#    --no-interaction \
#    --no-plugins \
#    --no-suggest \
#    --no-scripts \
#    --no-autoloader \
#    --prefer-dist && \
#    composer dump-autoload  --no-scripts --optimize && \
#ENTRYPOINT php-fpm
#    chmod 777 -R /var/www/autojobfinder && \
#    chmod -R 777 /var/www/autojobfinder/bootstrap/cache && \
#    cp .env.example .env && \
#    php artisan key:generate && \

