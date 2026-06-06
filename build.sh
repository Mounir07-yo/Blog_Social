#!/bin/bash
set -e

echo "🚀 Préparation du projet pour la production..."

# Installation des dépendances
composer install --no-dev --optimize-autoloader

# Optimisation de Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Créer le lien de stockage
php artisan storage:link

# Optimisation des fichiers
php artisan optimize

echo "✅ Projet prêt pour la production !"