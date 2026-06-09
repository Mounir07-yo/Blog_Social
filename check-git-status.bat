@echo off
chcp 65001 >nul
echo ================================================
echo   📊 ÉTAT DU REPOSITORY GIT - AREX
echo ================================================

echo.
echo 🔍 Vérifications en cours...

REM Vérifier si Git est installé
git --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Git n'est pas installé ou pas dans le PATH
    echo 💡 Installez Git : https://git-scm.com/download/windows
    pause
    exit /b 1
)
echo ✅ Git est installé

REM Vérifier si c'est un repository Git
if not exist ".git" (
    echo ❌ Ce dossier n'est pas un repository Git
    echo 💡 Initialisez avec : git init
    echo.
    set /p init_git="Initialiser le repository maintenant ? (o/n) : "
    if /i "!init_git!"=="o" (
        git init
        echo ✅ Repository Git initialisé
    ) else (
        pause
        exit /b 1
    )
) else (
    echo ✅ Repository Git détecté
)

echo.
echo 📋 INFORMATIONS DU REPOSITORY :
echo ================================
echo 📁 Dossier actuel : %cd%
echo 🌿 Branche actuelle : 
git branch --show-current 2>nul || echo "Aucune branche (premier commit requis)"

echo.
echo 🔗 Remotes configurées :
git remote -v 2>nul || echo "Aucune remote configurée"

echo.
echo 📊 ÉTAT DES FICHIERS :
echo ======================
git status --short 2>nul || echo "Erreur lors de la lecture du statut"

echo.
echo 📈 STATISTIQUES :
echo =================
echo Fichiers total dans le projet :
dir /s /b *.* | find /c /v ""

echo.
echo Commits dans ce repository :
git rev-list --count HEAD 2>nul || echo "0 (aucun commit)"

echo.
echo 📝 DERNIER COMMIT :
echo ==================
git log --oneline -1 2>nul || echo "Aucun commit trouvé"

echo.
echo 🔄 FICHIERS MODIFIÉS RÉCEMMENT :
echo ===============================
forfiles /m *.* /s /c "cmd /c if @isdir==FALSE echo @path @fdate @ftime" 2>nul | sort /r | head -10

echo.
echo 📋 RÉSUMÉ DES MODIFICATIONS AREX :
echo ==================================
echo ✅ APP_NAME changé en "AREX"
echo ✅ Titre et navigation mis à jour
echo ✅ Templates d'email modifiés  
echo ✅ Page d'accueil rebranded
echo ✅ Vues d'authentification mises à jour
echo ✅ Footer mis à jour
echo ✅ Configuration de production prête

echo.
echo 🎯 ACTIONS RECOMMANDÉES :
echo =========================
if exist ".env" (
    findstr "AREX" .env >nul && echo ✅ .env configuré pour AREX || echo ⚠️  .env nécessite mise à jour
)
if exist ".env.production" (
    findstr "AREX" .env.production >nul && echo ✅ .env.production configuré pour AREX || echo ⚠️  .env.production nécessite mise à jour
)
if exist "resources/views/layouts/app.blade.php" (
    findstr "AREX" resources/views/layouts/app.blade.php >nul && echo ✅ Layout principal mis à jour || echo ⚠️  Layout nécessite mise à jour
)

echo.
git status --porcelain 2>nul | find /c /v "" > temp_count.txt
set /p changes_count=<temp_count.txt
del temp_count.txt

if "%changes_count%"=="0" (
    echo 🎉 REPOSITORY À JOUR - Aucun changement à commiter
    echo 💡 Prêt pour le déploiement !
) else (
    echo ⚠️  %changes_count% fichiers avec des changements non commitées
    echo 💡 Utilisez push-to-github.bat pour commiter et pusher
)

echo.
echo 🚀 PROCHAINES ÉTAPES SUGGÉRÉES :
echo ================================
echo 1. .\push-to-github.bat          - Pusher les changements
echo 2. .\deploy-to-railway.bat       - Déployer sur Railway  
echo 3. .\prepare-deployment.bat      - Choisir une plateforme

echo.
pause