@echo off
chcp 65001 >nul
echo ================================================
echo   🚀 PRÉPARATION POUR L'HÉBERGEMENT
echo ================================================

echo.
echo 📋 CHOISISSEZ VOTRE PLATEFORME D'HÉBERGEMENT :
echo.
echo [1] 🚂 Railway (GRATUIT - Recommandé)
echo [2] ▲ Vercel + PlanetScale (GRATUIT)  
echo [3] 🌊 DigitalOcean (5$/mois)
echo [4] ☁️  Cloudflare Pages (1$/mois)
echo [5] 📖 Voir toutes les options
echo.
set /p choice="Votre choix (1-5): "

if "%choice%"=="1" (
    call :railway_setup
) else if "%choice%"=="2" (
    call :vercel_setup  
) else if "%choice%"=="3" (
    call :digitalocean_setup
) else if "%choice%"=="4" (
    call :cloudflare_setup
) else if "%choice%"=="5" (
    call :show_all_options
) else (
    echo Choix invalide !
    pause
    exit /b 1
)

goto :eof

:railway_setup
echo.
echo 🚂 CONFIGURATION RAILWAY
echo ========================

echo.
echo ✅ Votre code est déjà prêt pour Railway !
echo.
echo 📋 ÉTAPES À SUIVRE :
echo.
echo 1. 📂 Assurez-vous que votre code est sur GitHub
echo    git add .
echo    git commit -m "Ready for Railway deployment"
echo    git push
echo.
echo 2. 🌐 Allez sur : https://railway.app
echo.
echo 3. 🔐 Connectez-vous avec GitHub
echo.
echo 4. 🚀 Créez un nouveau projet :
echo    - "New Project"
echo    - "Deploy from GitHub repo"
echo    - Sélectionnez votre repository
echo.
echo 5. 💾 Ajoutez une base de données :
echo    - Cliquez "New"
echo    - "Database" → "Add MySQL"
echo.
echo 6. ⚡ Variables d'environnement (optionnel) :
echo    Railway les configure automatiquement !
echo.
echo 🎉 VOTRE BLOG SERA EN LIGNE EN 5 MINUTES !
echo.
echo 📊 Plan gratuit : 500h/mois (toujours allumé)
echo 🔗 URL finale : https://votre-projet-id.railway.app
echo.
set /p open_railway="Ouvrir Railway maintenant ? (o/n): "
if /i "%open_railway%"=="o" (
    start https://railway.app
)
goto :eof

:vercel_setup
echo.
echo ▲ CONFIGURATION VERCEL + PLANETSCALE
echo ====================================

echo.
echo 📋 ÉTAPES À SUIVRE :
echo.
echo 1. 💾 Base de données PlanetScale :
echo    - https://planetscale.com (compte gratuit)
echo    - Créez une database "blog-social"
echo    - Récupérez la connection string
echo.
echo 2. 🌐 Hébergement Vercel :
echo    - https://vercel.com (compte gratuit)
echo    - "Import Git Repository"
echo    - Sélectionnez votre repository GitHub
echo.
echo 3. ⚙️ Variables d'environnement dans Vercel :
echo    DATABASE_URL=mysql://user:pass@host/db
echo    APP_KEY=base64:votre-cle
echo    APP_URL=https://votre-projet.vercel.app
echo.
echo 🎉 Performance exceptionnelle + 100%% gratuit !
echo.
set /p open_vercel="Ouvrir Vercel maintenant ? (o/n): "
if /i "%open_vercel%"=="o" (
    start https://vercel.com
)
goto :eof

:digitalocean_setup
echo.
echo 🌊 CONFIGURATION DIGITALOCEAN APP PLATFORM
echo ==========================================

echo.
echo 💰 COÛT : 5$/mois (hébergement) + 15$/mois (database)
echo ⭐ QUALITÉ : Professionnelle, scaling automatique
echo.
echo 📋 ÉTAPES À SUIVRE :
echo.
echo 1. 🌐 Créez un compte : https://digitalocean.com
echo.
echo 2. 📱 App Platform :
echo    - "Create App"
echo    - "GitHub" → sélectionnez votre repository
echo    - Plan "Basic" (5$/mois)
echo.
echo 3. 💾 Base de données :
echo    - "Add Component" → "Database"
echo    - MySQL (15$/mois) ou PlanetScale (gratuit)
echo.
echo 4. ⚙️ Variables d'environnement :
echo    Automatiquement configurées par DigitalOcean
echo.
echo 🎯 Parfait pour un usage professionnel !
echo.
set /p open_do="Ouvrir DigitalOcean maintenant ? (o/n): "
if /i "%open_do%"=="o" (
    start https://digitalocean.com
)
goto :eof

:cloudflare_setup
echo.
echo ☁️ CONFIGURATION CLOUDFLARE PAGES
echo =================================

echo.
echo ⚠️  ATTENTION : Nécessite adaptation du code pour SQLite
echo 💰 COÛT : ~1$/mois (très économique)
echo ⚡ AVANTAGE : Ultra rapide (réseau mondial)
echo.
echo Cette option nécessite des modifications avancées.
echo Recommandé pour développeurs expérimentés.
echo.
echo Préférez Railway ou Vercel pour commencer !
goto :eof

:show_all_options
echo.
echo 📖 COMPARAISON COMPLÈTE DES OPTIONS
echo ==================================
echo.
echo 🆓 GRATUIT :
echo ┌─────────────┬─────────────┬─────────────┬─────────────┐
echo │ Platform    │ Hébergement │ Base données│ Complexité  │
echo ├─────────────┼─────────────┼─────────────┼─────────────┤
echo │ Railway     │ 500h/mois   │ MySQL incl. │ ⭐⭐⭐⭐⭐    │
echo │ Vercel      │ Gratuit     │ PlanetScale │ ⭐⭐⭐⭐      │
echo │ Heroku      │ Limité      │ PostgreSQL  │ ⭐⭐⭐       │
echo └─────────────┴─────────────┴─────────────┴─────────────┘
echo.
echo 💰 PAYANT :
echo ┌─────────────┬─────────────┬─────────────┬─────────────┐
echo │ Platform    │ Prix/mois   │ Performance │ Support     │
echo ├─────────────┼─────────────┼─────────────┼─────────────┤
echo │ DigitalOcean│ 5$ + 15$    │ ⭐⭐⭐⭐⭐    │ ⭐⭐⭐⭐⭐    │
echo │ AWS Lightsail│ 3.50$      │ ⭐⭐⭐⭐      │ ⭐⭐⭐       │
echo │ Cloudflare  │ 1$          │ ⭐⭐⭐⭐⭐    │ ⭐⭐⭐⭐      │
echo └─────────────┴─────────────┴─────────────┴─────────────┘
echo.
echo 🏆 NOTRE RECOMMANDATION : Railway (gratuit + simple)
goto :eof