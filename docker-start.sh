#!/bin/bash

echo "🚀 Starting AREX with Docker..."

# Attendre que la base soit disponible
echo "🗄️ Waiting for database..."
timeout=60
while [ $timeout -gt 0 ]; do
    if php artisan migrate:status > /dev/null 2>&1; then
        echo "✅ Database connection successful"
        break
    fi
    echo "⏳ Database not ready, waiting... ($timeout seconds left)"
    sleep 2
    ((timeout-=2))
done

# Migrations et seeders
echo "📊 Running migrations..."
php artisan migrate --force || echo "⚠️ Migration failed"

echo "🌱 Running seeders..."
php artisan db:seed --force || echo "⚠️ Seeders failed"

echo "📁 Creating storage link..."
php artisan storage:link || echo "⚠️ Storage link failed"

# Cache des configurations
php artisan config:cache || echo "⚠️ Config cache failed"
php artisan route:cache || echo "⚠️ Route cache failed"

echo "🌐 Starting Apache..."
exec apache2-foreground