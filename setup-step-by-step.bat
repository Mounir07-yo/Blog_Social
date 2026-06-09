@echo off
chcp 65001 >nul
echo ================================================
echo   CONFIGURATION ÉTAPE PAR ÉTAPE
echo ================================================

echo.
echo Étape 1/5 : Test de PHP...
php --version
if errorlevel 1 (
    echo ❌ PHP non disponible
    echo Démarrez XAMPP et réessayez
    pause
    exit /b 1
)
echo ✓ PHP fonctionne

echo.
echo Étape 2/5 : Test de connexion MySQL...
php test-db.php
if errorlevel 1 (
    echo.
    echo ❌ Problème de connexion MySQL
    echo.
    echo SOLUTIONS :
    echo 1. Démarrez XAMPP Control Panel
    echo 2. Cliquez Start pour MySQL
    echo 3. Cliquez Admin pour ouvrir phpMyAdmin
    echo 4. Créez une base "blog_social" si elle n'existe pas
    echo.
    pause
    exit /b 1
)

echo.
echo Étape 3/5 : Création des tables...
php create-tables.php
if errorlevel 1 (
    echo ❌ Erreur lors de la création
    pause
    exit /b 1
)

echo.
echo Étape 4/5 : Nettoyage cache Laravel...
php artisan config:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo ✓ Cache nettoyé

echo.
echo Étape 5/5 : Test final...
php artisan route:list | findstr "login" >nul
if errorlevel 1 (
    echo ❌ Problème avec les routes
) else (
    echo ✓ Routes Laravel OK
)

echo.
echo ================================================
echo   🎉 CONFIGURATION TERMINÉE !
echo ================================================
echo.
echo 🚀 Pour démarrer le blog :
echo   php artisan serve
echo.
echo 🌐 Puis allez sur : http://127.0.0.1:8000
echo 👤 Admin : admin@blog.com / password
echo.
set /p start="Démarrer maintenant ? (o/n): "
if /i "%start%"=="o" (
    echo.
    echo Démarrage du serveur...
    php artisan serve
)