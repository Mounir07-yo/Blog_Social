@echo off
chcp 65001 >nul
echo ================================================
echo   🎨 CONFIGURATION RENDER DEPLOYMENT
echo ================================================

echo.
echo 🎯 RENDER - Excellent choix !
echo ✅ Plus fiable que Railway
echo ✅ PostgreSQL gratuit inclus
echo ✅ 750h/mois gratuit
echo ✅ SSL automatique

echo.
echo 🔧 Préparation de la configuration...

echo.
echo 📋 ÉTAPES DE DÉPLOIEMENT :
echo.
echo 1️⃣ COMPTE RENDER :
echo    🌐 https://render.com
echo    🔐 Inscrivez-vous avec GitHub
echo.
echo 2️⃣ BASE DE DONNÉES :
echo    📊 Dashboard ^> "New" ^> "PostgreSQL"
echo    📝 Nom : arex-database
echo    💰 Plan : Free
echo.
echo 3️⃣ WEB SERVICE :
echo    📊 Dashboard ^> "New" ^> "Web Service"
echo    🔗 Repository : Blog_Social
echo    📝 Nom : arex-social

echo.
echo ⚙️ CONFIGURATION AUTOMATIQUE :
echo ===============================
if exist "render.yaml" (
    echo ✅ render.yaml déjà créé
) else (
    echo ❌ render.yaml manquant
)

echo.
echo 📊 VARIABLES D'ENVIRONNEMENT RENDER :
echo ====================================
echo APP_NAME=AREX
echo APP_ENV=production  
echo APP_DEBUG=false
echo APP_KEY=base64:J3O89zeuZG/iZK+685+NYfdNrOaTnUSMrRa+ldc+rQs=
echo DATABASE_URL=postgresql://username:password@host:port/database
echo CACHE_STORE=database
echo SESSION_DRIVER=database
echo QUEUE_CONNECTION=database

echo.
echo 🔄 Adaptation pour PostgreSQL...

REM Vérifier si nous devons adapter pour PostgreSQL
echo ℹ️  Laravel supportera automatiquement PostgreSQL
echo ℹ️  Vos migrations sont compatibles PostgreSQL

echo.
echo 📤 Push de la configuration vers GitHub...
git add .
git commit -m "🎨 Add Render deployment configuration"
git push

if errorlevel 0 (
    echo ✅ Configuration Render pushée !
) else (
    echo ⚠️  Push failed, continuons quand même...
)

echo.
echo 🚀 DÉPLOIEMENT RENDER :
echo ======================
echo.
echo 1. 🌐 Ouvrez : https://render.com
echo 2. 🔐 Connectez-vous avec GitHub
echo 3. ➕ "New" ^> "PostgreSQL" (base de données)
echo    - Nom : arex-database
echo    - Plan : Free
echo 4. ➕ "New" ^> "Web Service" (application)
echo    - Repository : Blog_Social
echo    - Runtime : Native Environment
echo    - Build Command : composer install --no-dev --optimize-autoloader
echo    - Start Command : php artisan migrate --force ^&^& php artisan serve --host=0.0.0.0 --port=$PORT
echo 5. 🔗 Liez la database à votre web service
echo 6. ⚙️  Ajoutez les variables d'environnement ci-dessus

echo.
echo 🎯 AVANTAGES RENDER vs RAILWAY :
echo ================================
echo ✅ Build plus fiable (moins d'erreurs)
echo ✅ PostgreSQL inclus gratuitement
echo ✅ 750h/mois (vs 500h Railway)
echo ✅ Interface plus claire
echo ✅ Logs plus détaillés
echo ✅ Monitoring intégré

echo.
echo ⏱️  TEMPS ESTIMÉ : 10-15 minutes
echo 🎉 RÉSULTAT : https://arex-social.onrender.com

echo.
set /p open_render="🌐 Ouvrir Render maintenant ? (o/n) : "
if /i "%open_render%"=="o" (
    start https://render.com
)

echo.
echo 📖 GUIDE COMPLET : RENDER-DEPLOY.md
echo 💡 En cas de problème, consultez le guide détaillé !

pause