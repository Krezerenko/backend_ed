FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    default-mysql-client \
    libaprutil1-dbd-mysql \
    && docker-php-ext-configure gd \
    && docker-php-ext-install pdo_mysql mysqli gd

RUN a2enmod rewrite dbd authn_dbd authz_dbd

ENV APACHE_DOCUMENT_ROOT /var/www/autoservice/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
