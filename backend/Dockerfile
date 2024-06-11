# Dockerfile
FROM php:8.3.8-cli
WORKDIR /app

# Telepítsd a szükséges PHP kiterjesztéseket
RUN docker-php-ext-install pdo_mysql

# Másold az alkalmazás fájljait a konténerbe
COPY . /app

# Telepítés Composer (ha szükséges)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

# Exponáld az 8000-es portot
EXPOSE 8000

# Indítsd el a PHP beépített szervert
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]