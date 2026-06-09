@echo off
echo ================================================
echo   TEST RAPIDE - MOT DE PASSE OUBLIÉ
echo ================================================

echo.
echo Nettoyage du cache...
php artisan config:clear >nul 2>&1

echo.
echo 🔧 Génération d'un lien de test pour admin@blog.com...
php generate-reset-link.php admin@blog.com

echo.
echo 🌐 Pour tester l'interface complète :
echo 1. php artisan serve
echo 2. http://127.0.0.1:8000/forgot-password  
echo 3. Saisissez : admin@blog.com
echo 4. Le lien apparaîtra directement sur la page !
echo.
pause