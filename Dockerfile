# syntax=docker/dockerfile:1

FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        curl \
        npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000

CMD ["php-fpm"]