FROM composer:2.7 as composer
FROM node:22-bookworm as node
FROM dunglas/frankenphp:php8.2.31-bookworm

WORKDIR /app

# Install git and unzip
RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*

# Copy composer from official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy application files
COPY . .

# Setup Railway MySQL configuration
RUN cp config/database-railway.php config/database.php

# Install composer dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --optimize-autoloader --no-scripts --no-interaction

# Install Node dependencies
RUN npm install && npm run build

# Create storage directories
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache && chmod -R a+rw storage

# Cache configuration
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Start command
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT