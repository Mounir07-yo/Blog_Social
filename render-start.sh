#!/bin/bash

# SCRIPT DE DÉMARRAGE RENDER POUR AREX
# Gère le démarrage avec PostgreSQL

echo "🚀 Starting AREX application..."

# 1. Attendre que la base soit disponible
echo "🗄️ Waiting for database..."
timeout=30
while [ $timeout -gt 0 ]; do
    if php artisan migrate:status > /dev/null 2>&1; then
        echo "✅ Database connection successful"
        break
    fi
    echo "⏳ Database not ready, waiting... ($timeout seconds left)"
    sleep 2
    ((timeout-=2))
done

if [ $timeout -eq 0 ]; then
    echo "❌ Database connection timeout"
    echo "ℹ️ Continuing anyway - will retry during migration"
fi

# 2. Exécuter les migrations avec retry
echo "📊 Running database migrations..."
max_retries=3
retry=0
while [ $retry -lt $max_retries ]; do
    if php artisan migrate --force; then
        echo "✅ Migrations completed"
        break
    else
        retry=$((retry + 1))
        echo "⚠️ Migration attempt $retry failed, retrying..."
        sleep 5
    fi
done

# 3. Seeders (optionnel, continuer même si échec)
echo "🌱 Running database seeders..."
php artisan db:seed --force || echo "⚠️ Seeders failed (non-critical)"

# 4. Storage link
echo "📁 Creating storage link..."
php artisan storage:link || echo "⚠️ Storage link failed (non-critical)"

# 5. Optimisations finales
echo "⚡ Final optimizations..."
php artisan config:cache || echo "⚠️ Config cache failed (non-critical)"
php artisan route:cache || echo "⚠️ Route cache failed (non-critical)"

# 6. Démarrer le serveur
echo "🌐 Starting web server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}