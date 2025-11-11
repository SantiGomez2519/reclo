FROM php:8.3.11-apache

RUN apt-get update -y && apt-get install -y \
    openssl zip unzip git curl \
    && docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

COPY ./public/.htaccess /var/www/html/.htaccess
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

RUN php artisan key:generate || true

RUN chmod -R 777 storage bootstrap/cache
