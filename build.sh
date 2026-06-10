#!/bin/bash

# Script de build pour Railway avec installation explicite MySQL
echo "Installing PHP MySQL extensions..."

# Installation des extensions PHP via apt (si disponible)
if command -v apt-get &> /dev/null; then
    apt-get update
    apt-get install -y php8.2-mysql php8.2-pdo-mysql
fi

# Installation Composer
echo "Running Composer install..."
composer install --no-dev --optimize-autoloader

echo "Build completed successfully!"