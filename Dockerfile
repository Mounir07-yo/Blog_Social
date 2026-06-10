# Dockerfile simple pour AREX sur Railway
FROM php:8.2-apache

# Variables d'environnement
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER=1

# Installation des extensions PHP essentielles
RUN apt-get update && apt-get install -y \
    git zip unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration Apache pour Laravel
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Copie et installation
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configuration Railway MySQL
RUN cp config/database-railway.php config/database.php

# Permissions Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Port d'écoute
EXPOSE 80

# Commande de démarrage
CMD ["bash", "-c", "php artisan migrate --force && php artisan db:seed --force && apache2-foreground"]