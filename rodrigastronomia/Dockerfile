FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libicu-dev default-mysql-client unzip curl git \
    && docker-php-ext-install mysqli pdo pdo_mysql intl

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar configuración personalizada de Apache
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar entrypoint y dar permisos
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Copiar .env si es necesario
COPY .env ./

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Usar entrypoint
ENTRYPOINT ["/entrypoint.sh"]
