FROM php:7.2-apache
EXPOSE 80
RUN docker-php-ext-install pdo pdo_mysql mysqli
COPY ./index.php /var/www/html
COPY ./style.css /var/www/html

