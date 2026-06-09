@echo off
chcp 65001 >nul
echo ================================================
echo   🚂 DÉPLOIEMENT AUTOMATISÉ RAILWAY
echo ================================================

echo.
echo 📋 Vérification de l'état actuel...

REM Vérifier si Git est initialisé
if not exist ".git" (
    echo 🔧 Initialisation de Git...
    git init
    git add .
    git commit -m "🚀 Initial commit - Blog social ready for deployment"
) else (
    echo ✅ Repository Git trouvé
)

REM Vérifier si des changements non commitées existent
git diff-index --quiet HEAD --
if errorlevel 1 (
    echo 📤 Commit des dernières modifications...
    git add .
    git commit -m "🔄 Latest changes before deployment"
)

REM Vérifier la configuration
echo.
echo 🔍 Vérification de la configuration...
if exist "railway.json" (
    echo ✅ railway.json trouvé
) else (
    echo ❌ railway.json manquant
    echo 🔧 Création de railway.json...
    echo {> railway.json
    echo   "build": {>> railway.json
    echo     "builder": "nixpacks">> railway.json
    echo   },>> railway.json
    echo   "deploy": {>> railway.json
    echo     "startCommand": "php artisan migrate --force && php artisan db:seed --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT">> railway.json
    echo   }>> railway.json
    echo }>> railway.json
    echo ✅ railway.json créé
)

if exist ".env.production" (
    echo ✅ .env.production trouvé
) else (
    echo 🔧 Création de .env.production...
    echo APP_NAME="Mon Blog Social"> .env.production
    echo APP_ENV=production>> .env.production
    echo APP_DEBUG=false>> .env.production
    echo APP_URL=https://votre-projet.railway.app>> .env.production
    echo.>> .env.production
    echo DB_CONNECTION=mysql>> .env.production
    echo.>> .env.production
    echo CACHE_STORE=database>> .env.production
    echo SESSION_DRIVER=database>> .env.production
    echo QUEUE_CONNECTION=database>> .env.production
    echo.>> .env.production
    echo LOG_CHANNEL=stack>> .env.production
    echo LOG_LEVEL=error>> .env.production
    echo ✅ .env.production créé
)

echo.
echo 📊 INFORMATIONS DE DÉPLOIEMENT :
echo ================================
echo.
echo 🏷️  Nom du projet : Mon Blog Social
echo 🌐 Framework : Laravel + MySQL
echo 💾 Base de données : MySQL (incluse)
echo 📧 Email : Configuration optionnelle
echo 🔐 Sécurité : HTTPS automatique
echo.

REM Vérifier si il y a une remote GitHub
git remote get-url origin >nul 2>&1
if errorlevel 1 (
    echo ⚠️  ATTENTION : Aucune remote GitHub configurée !
    echo.
    echo 📋 ÉTAPES À SUIVRE :
    echo.
    echo 1. 📂 Créez un repository sur GitHub :
    echo    https://github.com/new
    echo.
    echo 2. 🔗 Ajoutez la remote :
    echo    git remote add origin https://github.com/VOTRE-USERNAME/blog-social.git
    echo    git push -u origin main
    echo.
    echo 3. 🚂 Déployez sur Railway :
    echo    https://railway.app
    echo    - Login with GitHub
    echo    - New Project ^> Deploy from GitHub repo
    echo    - Sélectionnez votre repository
    echo.
    set /p github_username="Entrez votre nom d'utilisateur GitHub (optionnel): "
    if not "%github_username%"=="" (
        set github_url=https://github.com/%github_username%/blog-social.git
        echo.
        echo 🔧 Configuration suggérée :
        echo git remote add origin !github_url!
        echo git push -u origin main
        echo.
        set /p add_remote="Ajouter cette remote maintenant ? (o/n): "
        if /i "!add_remote!"=="o" (
            git remote add origin !github_url!
            git push -u origin main
            if errorlevel 0 (
                echo ✅ Code poussé sur GitHub !
            ) else (
                echo ❌ Erreur lors du push. Vérifiez vos credentials GitHub.
            )
        )
    )
) else (
    echo ✅ Remote GitHub configurée
    echo 📤 Push des dernières modifications...
    git push
    if errorlevel 0 (
        echo ✅ Code synchronisé avec GitHub !
    ) else (
        echo ⚠️  Problème lors du push. Continuons...
    )
)

echo.
echo 🚂 ÉTAPES RAILWAY :
echo ==================
echo.
echo 1. 🌐 Allez sur https://railway.app
echo 2. 🔐 Cliquez "Login with GitHub"  
echo 3. ➕ Cliquez "New Project"
echo 4. 📂 Sélectionnez "Deploy from GitHub repo"
echo 5. 🎯 Choisissez votre repository
echo 6. ⏱️  Attendez le déploiement (2-5 minutes)
echo 7. 💾 Ajoutez MySQL : "New" ^> "Database" ^> "Add MySQL"
echo 8. 🎉 Votre blog est en ligne !
echo.

echo 📋 VARIABLES D'ENVIRONNEMENT (Railway les configure automatiquement) :
echo =====================================================================
echo ✅ APP_KEY : Généré automatiquement
echo ✅ DATABASE_URL : Connecté automatiquement au MySQL
echo ✅ APP_URL : Généré automatiquement
echo.

echo 🎯 APRÈS LE DÉPLOIEMENT :
echo ==========================
echo 📊 Monitoring : Railway Dashboard
echo 📝 Logs : Onglet "Logs" en temps réel  
echo 🔧 Variables : Onglet "Variables"
echo 🌐 Domaine : Onglet "Settings" ^> "Domains"
echo.

echo 💡 COMPTES DE TEST DISPONIBLES :
echo ================================
echo 👤 admin@blog.com / password (Administrateur)
echo 👤 Créez d'autres comptes via l'inscription
echo.

set /p open_railway="🚀 Ouvrir Railway maintenant ? (o/n): "
if /i "%open_railway%"=="o" (
    start https://railway.app
    echo.
    echo 🎊 Railway ouvert ! Suivez les étapes ci-dessus.
)

echo.
echo 📖 GUIDES SUPPLÉMENTAIRES :
echo ===========================
echo 📄 RAILWAY-DEPLOY.md - Guide détaillé Railway
echo 📄 GUIDE-HEBERGEMENT-2024.md - Toutes les options
echo 📄 CONFIGURATION-EMAIL.md - Configuration email
echo.

pause