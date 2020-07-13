FROM php:7.4-fpm
RUN apt-get clean
RUN apt-get update
RUN apt-get install -y \
        libzip-dev \
        zip \
        git \
  && docker-php-ext-install zip

WORKDIR /usr/share/nginx/html
