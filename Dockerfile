FROM php:8.2-apache

# Extensões PHP para falar com PostgreSQL (Neon) e, se precisares, MySQL
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copia o projeto para a pasta pública do Apache
COPY . /var/www/html/

# Pasta de uploads com permissão de escrita
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80