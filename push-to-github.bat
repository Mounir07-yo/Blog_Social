@echo off
chcp 65001 >nul
echo ================================================
echo   📤 PUSH VERS GITHUB - AREX
echo ================================================

echo.
echo 🔍 Vérification de l'état du repository...

REM Vérifier si Git est initialisé
if not exist ".git" (
    echo ❌ Repository Git non initialisé !
    echo.
    echo 🔧 Initialisation du repository...
    git init
    echo ✅ Repository Git initialisé
)

REM Vérifier le statut Git
echo.
echo 📋 État actuel des fichiers :
git status --short

echo.
echo 📝 Modifications récentes :
echo ✅ Renommage du blog en "AREX"
echo ✅ Mise à jour de tous les templates
echo ✅ Configuration d'hébergement prête
echo ✅ Système d'email sécurisé
echo ✅ Fonctionnalités complètes (blog, messagerie, signalements)

echo.
set /p commit_message="📝 Message de commit (ou Entrée pour message automatique) : "

if "%commit_message%"=="" (
    set commit_message=🚀 AREX - Réseau social complet avec nouvelles fonctionnalités
)

echo.
echo 📦 Ajout de tous les fichiers...
git add .

if errorlevel 1 (
    echo ❌ Erreur lors de l'ajout des fichiers
    pause
    exit /b 1
)

echo ✅ Fichiers ajoutés

echo.
echo 💾 Création du commit...
git commit -m "%commit_message%"

if errorlevel 1 (
    echo ⚠️  Aucun changement à commiter ou erreur
    echo Vérification des changements...
    git status
) else (
    echo ✅ Commit créé avec succès
)

echo.
echo 🔗 Vérification de la remote GitHub...
git remote get-url origin >nul 2>&1

if errorlevel 1 (
    echo ❌ Aucune remote GitHub configurée !
    echo.
    echo 📋 CONFIGURATION REQUISE :
    echo.
    echo 1. 📂 Créez un repository sur GitHub :
    echo    https://github.com/new
    echo    Nom suggéré : AREX ou arex-social-network
    echo.
    echo 2. 🔗 Configurez la remote :
    set /p github_username="Entrez votre nom d'utilisateur GitHub : "
    if not "%github_username%"=="" (
        set /p repo_name="Nom du repository (par défaut: AREX) : "
        if "!repo_name!"=="" set repo_name=AREX
        
        set github_url=https://github.com/!github_username!/!repo_name!.git
        echo.
        echo 🔧 Ajout de la remote : !github_url!
        git remote add origin !github_url!
        
        if errorlevel 0 (
            echo ✅ Remote ajoutée avec succès
            set remote_added=1
        ) else (
            echo ❌ Erreur lors de l'ajout de la remote
            pause
            exit /b 1
        )
    ) else (
        echo ⚠️  Configuration manuelle requise
        echo Exécutez : git remote add origin https://github.com/USERNAME/REPO.git
        pause
        exit /b 1
    )
) else (
    echo ✅ Remote GitHub configurée
    git remote -v
    set remote_added=0
)

echo.
echo 🚀 Push vers GitHub...

if "%remote_added%"=="1" (
    echo Premier push - configuration de la branch main...
    git branch -M main
    git push -u origin main
) else (
    git push
)

if errorlevel 0 (
    echo.
    echo 🎉 SUCCESS ! Code poussé sur GitHub avec succès !
    echo.
    echo 📊 RÉSUMÉ :
    echo ========================================
    echo ✅ Projet AREX mis à jour
    echo ✅ Toutes les fonctionnalités intégrées
    echo ✅ Prêt pour le déploiement
    echo.
    echo 🌐 VOTRE REPOSITORY :
    git remote get-url origin
    echo.
    echo 🚀 PROCHAINES ÉTAPES :
    echo 1. Déployez sur Railway : .\deploy-to-railway.bat
    echo 2. Ou choisissez une autre plateforme : .\prepare-deployment.bat
    echo.
) else (
    echo.
    echo ❌ ERREUR lors du push !
    echo.
    echo 🔧 SOLUTIONS POSSIBLES :
    echo.
    echo 1. 🔑 Authentification requise :
    echo    - Configurez vos credentials GitHub
    echo    - Ou utilisez un token d'accès personnel
    echo.
    echo 2. 📂 Repository inexistant :
    echo    - Créez le repository sur GitHub d'abord
    echo    - Vérifiez que le nom correspond
    echo.
    echo 3. 🌐 Problème de connexion :
    echo    - Vérifiez votre connexion internet
    echo    - Réessayez dans quelques minutes
    echo.
    set /p retry="Réessayer maintenant ? (o/n) : "
    if /i "!retry!"=="o" (
        git push
        if errorlevel 0 (
            echo ✅ Push réussi !
        ) else (
            echo ❌ Échec persistant. Vérifiez votre configuration GitHub.
        )
    )
)

echo.
echo 📖 GUIDES DISPONIBLES :
echo - README-DEPLOY.md : Guide de déploiement complet
echo - GUIDE-HEBERGEMENT-2024.md : Options d'hébergement
echo - RAILWAY-DEPLOY.md : Déploiement Railway spécifique

echo.
pause