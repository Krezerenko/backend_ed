FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libaprutil1-dbd-mysql \
    && docker-php-ext-install pdo_mysql mysqli

RUN a2enmod dbd authn_dbd

ENV APACHE_DOCUMENT_ROOT /var/www/autoservice/public