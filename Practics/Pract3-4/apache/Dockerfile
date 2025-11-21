FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libaprutil1-dbd-mysql \
    git \
    unzip \
    libfreetype6-dev \
    fonts-dejavu \
    libpng-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install -j$(nproc) pdo_mysql mysqli gd

RUN a2enmod dbd authn_dbd rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /var/www/autoservice/public