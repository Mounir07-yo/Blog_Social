@echo off
chcp 65001 >nul
echo ================================================
echo   🚀 DÉPLOIEMENT ALTERNATIF - AREX
echo ================================================

echo.
echo ❌ Railway build échoue ? Pas de problème !
echo 🎯 Nous avons des alternatives MEILLEURES !

echo.
echo 📋 CHOISISSEZ VOTRE SOLUTION :
echo.
echo [1] 🟦 VERCEL + PLANETSCALE (Recommandé)
echo     ✅ GRATUIT à vie
echo     ✅ Performance EXCEPTIONNELLE 
echo     ✅ Plus simple que Railway
echo     ✅ Déploiement en 2 minutes
echo.
echo [2] 🟩 NETLIFY + SUPABASE
echo     ✅ GRATUIT pour projets personnels
echo     ✅ Interface très simple
echo     ✅ Base PostgreSQL incluse
echo.
echo [3] 🟨 HEROKU (Plan gratuit limité)
echo     ✅ Classique et fiable
echo     ✅ PostgreSQL inclus
echo.
echo [4] 💰 DIGITALOCEAN (5$/mois - Le plus pro)
echo     ✅ Performance professionnelle
echo     ✅ Support 24/7
echo     ✅ Scaling automatique
echo.
echo [5] 🔧 DÉBUGGER RAILWAY (une dernière fois)
echo.
set /p choice="Votre choix (1-5) : "

if "%choice%"=="1" goto :vercel_deploy
if "%choice%"=="2" goto :netlify_deploy  
if "%choice%"=="3" goto :heroku_deploy
if "%choice%"=="4" goto :digitalocean_deploy
if "%choice%"=="5" goto :debug_railway
goto :invalid_choice

:vercel_deploy
echo.
echo 🟦 DÉPLOIEMENT VERCEL + PLANETSCALE
echo ===================================
echo.
echo 🎯 AVANTAGES :
echo ✅ 100%% GRATUIT (même pour production)
echo ✅ Performance mondiale (CDN)
echo ✅ Base MySQL serverless (PlanetScale)
echo ✅ Déploiement automatique GitHub
echo ✅ HTTPS + domaine personnalisé gratuit
echo.
echo 📋 ÉTAPES :
echo.
echo 1️⃣ BASE DE DONNÉES :
echo    🌐 Allez sur : https://planetscale.com
echo    📝 Créez un compte (gratuit)
echo    ➕ Créez une database "arex-db"
echo    🔑 Récupérez la connection string
echo.
echo 2️⃣ HÉBERGEMENT :
echo    🌐 Allez sur : https://vercel.com
echo    🔐 Connectez-vous avec GitHub
echo    📂 Import repository : Blog_Social
echo    ⚙️  Framework Preset : Other
echo    📁 Root Directory : ./
echo.
echo 3️⃣ VARIABLES D'ENVIRONNEMENT :
echo    DATABASE_URL=mysql://user:pass@host/arex-db?sslaccept=strict
echo    APP_KEY=base64:votre-cle
echo    APP_ENV=production
echo    APP_DEBUG=false
echo    APP_URL=https://votre-projet.vercel.app
echo.
set /p open_vercel="🚀 Ouvrir Vercel maintenant ? (o/n) : "
if /i "%open_vercel%"=="o" (
    start https://vercel.com
    start https://planetscale.com
)
goto :end

:netlify_deploy
echo.
echo 🟩 DÉPLOIEMENT NETLIFY + SUPABASE
echo =================================
echo.
echo 🎯 SOLUTION SIMPLE :
echo ✅ Interface très intuitive
echo ✅ Base PostgreSQL + API automatique
echo ✅ Authentification intégrée
echo.
echo ⚠️  ATTENTION : Nécessite adaptation Laravel pour PostgreSQL
echo 💡 Recommandé pour développeurs intermédiaires
echo.
set /p open_netlify="🚀 Ouvrir Netlify maintenant ? (o/n) : "
if /i "%open_netlify%"=="o" (
    start https://netlify.com
    start https://supabase.com
)
goto :end

:heroku_deploy
echo.
echo 🟨 DÉPLOIEMENT HEROKU
echo ====================
echo.
echo 🎯 SOLUTION CLASSIQUE :
echo ✅ Très documenté
echo ✅ PostgreSQL inclus
echo ⚠️  Plan gratuit limité (550h/mois)
echo.
echo 📋 ÉTAPES :
echo 1. Installer Heroku CLI
echo 2. heroku create arex-social
echo 3. git push heroku main
echo.
set /p open_heroku="🚀 Ouvrir Heroku maintenant ? (o/n) : "
if /i "%open_heroku%"=="o" (
    start https://heroku.com
)
goto :end

:digitalocean_deploy
echo.
echo 💰 DÉPLOIEMENT DIGITALOCEAN APP PLATFORM
echo ========================================
echo.
echo 🎯 SOLUTION PROFESSIONNELLE :
echo ✅ 5$/mois - Performance garantie
echo ✅ Scaling automatique
echo ✅ Support technique 24/7
echo ✅ Base MySQL managée (+15$/mois)
echo.
echo 💡 Alternative économique : DigitalOcean + PlanetScale
echo    App Platform (5$/mois) + PlanetScale (gratuit)
echo.
set /p open_do="🚀 Ouvrir DigitalOcean maintenant ? (o/n) : "
if /i "%open_do%"=="o" (
    start https://digitalocean.com
)
goto :end

:debug_railway
echo.
echo 🔧 DÉBOGAGE RAILWAY - DERNIÈRE TENTATIVE
echo ========================================
echo.
echo 🔍 Créons une version ULTRA-SIMPLIFIÉE pour Railway :

REM Créer une version minimaliste de railway.json
echo {"build":{"builder":"nixpacks"},"deploy":{"startCommand":"php artisan serve --host=0.0.0.0 --port=$PORT"}} > railway-minimal.json

echo ✅ Configuration minimaliste créée : railway-minimal.json
echo.
echo 📋 ESSAYEZ CECI SUR RAILWAY :
echo.
echo 1. Dashboard Railway ^> Settings ^> Environment
echo 2. Ajoutez ces variables UNE PAR UNE :
echo    APP_ENV=production
echo    APP_DEBUG=false  
echo    APP_KEY=base64:J3O89zeuZG/iZK+685+NYfdNrOaTnUSMrRa+ldc+rQs=
echo.
echo 3. Remplacez railway.json par railway-minimal.json :
copy railway-minimal.json railway.json /y
echo    ✅ Configuration simplifiée appliquée
echo.
echo 4. Push les changements :
git add .
git commit -m "🔧 Railway minimal config"  
git push
echo.
echo 5. Railway devrait redéployer automatiquement
echo.
echo ⚠️  SI ÇA NE MARCHE TOUJOURS PAS :
echo    Railway a des problèmes techniques fréquents
echo    → Choisissez Vercel (option 1) - beaucoup plus fiable !

goto :end

:invalid_choice
echo.
echo ❌ Choix invalide. Relancez le script.
goto :end

:end
echo.
echo 💡 CONSEIL : Vercel + PlanetScale est généralement plus fiable que Railway
echo 📈 Performance supérieure et moins de problèmes de build
echo.
echo 📞 Si vous avez des questions, dites-moi quelle option vous choisissez !
pause