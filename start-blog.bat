@echo off
cls
echo ========================================
echo        🚀 DEMARRAGE DU BLOG
echo ========================================
echo.

echo ✅ Verification de l'environnement...
if not exist "vendor" (
    echo ❌ Dependances manquantes, installation...
    composer install --no-dev --optimize-autoloader
)

if not exist "database/database.sqlite" (
    echo ❌ Base de donnees manquante, creation...
    type nul > "database/database.sqlite"
    php artisan migrate --force
    php artisan db:seed --force
)

echo.
echo ✅ Configuration optimale...
php artisan config:cache >nul 2>&1
php artisan route:cache >nul 2>&1

echo.
echo ========================================
echo    🎉 BLOG PRET !
echo ========================================
echo 🌐 URL du blog: http://127.0.0.1:8000
echo 👤 Compte test: admin@blog.com
echo 🔑 Mot de passe: password
echo.
echo ⏹️  Pour arreter: Ctrl+C
echo 📖 Aide: voir README.md
echo ========================================
echo.

start http://127.0.0.1:8000
php artisan serve