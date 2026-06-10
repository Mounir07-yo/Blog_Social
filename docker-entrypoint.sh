#!/bin/bash

echo "🚀 Starting AREX..."

# Attendre la base de données
echo "🗄️ Waiting for database connection..."
max_attempts=30
attempt=0
while [ $attempt -lt $max_attempts ]; do
    if php artisan migrate:status >/dev/null 2>&1; then
        echo "✅ Database connected successfully"
        break
    fi
    echo "⏳ Attempt $((attempt + 1))/$max_attempts - Waiting for database..."
    sleep 2
    attempt=$((attempt + 1))
done

# Exécuter les migrations
echo "📊 Running database migrations..."
php artisan migrate --force || echo "⚠️ Migrations failed - continuing anyway"

# Seeders (optionnel)
echo "🌱 Running seeders..."
php artisan db:seed --force || echo "⚠️ Seeders failed - continuing anyway"

# Storage link
echo "📁 Creating storage symbolic link..."
php artisan storage:link || echo "⚠️ Storage link failed - continuing anyway"

# Optimisations Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache || echo "⚠️ Config cache failed"
php artisan route:cache || echo "⚠️ Route cache failed"
php artisan view:cache || echo "⚠️ View cache failed"

echo "✅ AREX initialization completed!"

# Démarrer les services (l'image s'en charge)
exec "$@"