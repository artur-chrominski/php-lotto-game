FROM php:8.2-apache

# Instalacja zależności
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN a2enmod rewrite

WORKDIR /var/www/html
RUN composer install

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN service apache2 restart
