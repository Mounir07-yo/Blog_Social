@echo off
echo ====================================
echo   🚂 SWITCH TO RAILWAY DEPLOYMENT  
echo ====================================
echo.
echo 💡 Railway sera plus simple que Render pour AREX
echo ✅ Support MySQL natif (pas besoin PostgreSQL)
echo ✅ Build moins strict
echo ✅ Configuration automatique Laravel
echo.
echo 🔄 Préparation pour Railway...

REM Restaurer la config MySQL
echo 📊 Restoring MySQL configuration...
git checkout HEAD~3 -- config/database.php

REM Créer fichier Railway
echo 🚂 Creating railway.json...
echo {> railway.json
echo   "build": {>> railway.json
echo     "command": "composer install --no-dev --optimize-autoloader">> railway.json
echo   },>> railway.json
echo   "deploy": {>> railway.json  
echo     "startCommand": "php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT">> railway.json
echo   }>> railway.json
echo }>> railway.json

echo.
echo ✅ Configuration Railway prête !
echo.
echo 📤 Push vers GitHub...
git add .
git commit -m "🚂 Switch to Railway deployment - MySQL configuration"
git push

echo.
echo 🌐 Maintenant allez sur : https://railway.app
echo 🔗 Connect GitHub → Deploy Blog_Social
echo 💾 Railway détecte automatiquement Laravel !
echo.
pause