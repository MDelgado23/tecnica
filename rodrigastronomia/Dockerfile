FROM php:8.2-apache

RUN apt-get update && apt-get install -y libicu-dev \
  && docker-php-ext-install mysqli pdo pdo_mysql intl

RUN a2enmod rewrite

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html