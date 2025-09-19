FROM php:apache
EXPOSE 80
RUN apt-get update && apt-get install -y \
     libfreetype-dev \
     libjpeg62-turbo-dev \
     libpng-dev \
     libonig-dev \
     libgmp-dev \
     && docker-php-ext-configure gd --with-freetype --with-jpeg \
     && docker-php-ext-install -j$(nproc) gd gmp \
     && docker-php-ext-enable gd
