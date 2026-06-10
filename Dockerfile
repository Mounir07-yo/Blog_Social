FROM dunglas/frankenphp:php8.2.31-bookworm

WORKDIR /app

# Install required PHP extensions for Railway MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copy application files
COPY . .

# Setup Railway MySQL configuration
RUN cp config/database-railway.php config/database.php

# Install composer dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Install Node dependencies
RUN npm install && npm run build

# Create storage directories
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache && chmod -R a+rw storage

# Cache configuration
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Start command
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT