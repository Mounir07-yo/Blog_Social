#!/bin/bash

# SCRIPT DE BUILD RENDER POUR AREX
# Résout les problèmes courants de déploiement

echo "🚀 Starting AREX build process..."

# 1. Définir la version PHP
echo "📋 Setting PHP version..."
echo "php: '8.1'" > .php-version

# 2. Variables d'environnement pour Composer
export COMPOSER_ALLOW_SUPERUSER=1
export COMPOSER_NO_INTERACTION=1
export COMPOSER_MEMORY_LIMIT=-1

# 3. Installation des dépendances avec options robustes
echo "📦 Installing Composer dependencies..."
composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-scripts \
    --ignore-platform-reqs

# 4. Vérification des dépendances critiques
echo "🔍 Checking Laravel installation..."
if [ ! -f "vendor/laravel/framework/src/Illuminate/Foundation/Application.php" ]; then
    echo "❌ Laravel not properly installed"
    exit 1
fi

# 5. Copie de la configuration PostgreSQL
echo "🗄️ Setting up PostgreSQL configuration..."
cp config/database-postgresql.php config/database.php

# 6. Cache des configurations (si possible)
echo "⚡ Optimizing Laravel..."
if [ -f "artisan" ]; then
    php artisan config:clear || echo "⚠️ Config clear failed (non-critical)"
    php artisan route:clear || echo "⚠️ Route clear failed (non-critical)"
    php artisan view:clear || echo "⚠️ View clear failed (non-critical)"
fi

echo "✅ Build completed successfully!"