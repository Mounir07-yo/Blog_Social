# Dockerfile ULTRA-SIMPLE pour AREX
# Utilise une image PHP Laravel prête à l'emploi
FROM webdevops/php-nginx:8.1

# Variables d'environnement
ENV WEB_DOCUMENT_ROOT=/app/public
ENV APP_ENV=production

# Copier l'application
COPY . /app

# Aller dans le répertoire de l'app
WORKDIR /app

# Configuration PostgreSQL
RUN cp config/database-postgresql.php config/database.php

# Installation des dépendances Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions
RUN chown -R application:application /app \
    && chmod -R 755 /app/storage \
    && chmod -R 755 /app/bootstrap/cache

# Script de démarrage
COPY docker-entrypoint.sh /opt/docker/provision/entrypoint.d/30-laravel-setup.sh
RUN chmod +x /opt/docker/provision/entrypoint.d/30-laravel-setup.sh