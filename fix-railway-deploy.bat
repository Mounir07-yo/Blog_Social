@echo off
chcp 65001 >nul
echo ================================================
echo   🔧 CORRECTION DÉPLOIEMENT RAILWAY
echo ================================================

echo.
echo 🔍 Diagnostic des problèmes Railway...
php debug-railway-build.php

echo.
echo 🛠️  CORRECTIONS APPLIQUÉES :
echo ===========================
echo ✅ PHP version changée de 8.2 vers 8.1 (plus compatible)
echo ✅ railway.json optimisé avec build command
echo ✅ Procfile mis à jour avec commandes complètes
echo ✅ nixpacks.toml ajouté pour configuration avancée

echo.
echo 📋 VÉRIFICATIONS FINALES :
echo =========================

REM Vérifier composer.json
findstr "8.1" composer.json >nul && echo ✅ PHP 8.1 configuré || echo ❌ PHP version non mise à jour

REM Vérifier railway.json
if exist "railway.json" (
    echo ✅ railway.json présent
) else (
    echo ❌ railway.json manquant
)

REM Vérifier nixpacks.toml
if exist "nixpacks.toml" (
    echo ✅ nixpacks.toml créé
) else (
    echo ❌ nixpacks.toml manquant
)

echo.
echo 🔄 Régénération de composer.lock...
composer install --no-dev --optimize-autoloader
if errorlevel 0 (
    echo ✅ composer.lock mis à jour
) else (
    echo ❌ Erreur composer install
    echo 💡 Essayez : composer update
)

echo.
echo 📤 Push des corrections vers GitHub...

git add .
git commit -m "🔧 Fix Railway deployment: PHP 8.1 + optimized config"
git push

if errorlevel 0 (
    echo ✅ Corrections pushées sur GitHub !
) else (
    echo ❌ Erreur lors du push
)

echo.
echo 🚂 INSTRUCTIONS RAILWAY :
echo ========================
echo.
echo 1. 🌐 Allez sur votre projet Railway
echo 2. 🔄 Le redéploiement se lance automatiquement
echo 3. 📊 Surveillez les logs de build en temps réel
echo.
echo 🎯 SI LE BUILD ÉCHOUE ENCORE :
echo ==============================
echo.
echo A. Vérifiez les logs Railway pour l'erreur exacte
echo B. Variables d'environnement à ajouter manuellement :
echo    - APP_ENV=production
echo    - APP_DEBUG=false  
echo    - APP_KEY=(généré automatiquement)
echo.
echo C. Base de données :
echo    - Ajoutez MySQL depuis Railway dashboard
echo    - Railway configurera DATABASE_URL automatiquement
echo.
echo D. Si problème persiste :
echo    - Essayez Vercel + PlanetScale (alternative gratuite)
echo    - Ou DigitalOcean App Platform (5$/mois, plus stable)

echo.
echo 📖 ALTERNATIVES SI RAILWAY NE FONCTIONNE PAS :
echo ===============================================
echo.
echo 🔄 Option 1 - Forcer rebuild Railway :
echo    1. Settings ^> Environment ^> Variables
echo    2. Ajoutez: NIXPACKS_BUILD_CMD="composer install --no-dev"
echo    3. Redéployez manuellement
echo.
echo ▲ Option 2 - Vercel (gratuit) :
echo    .\prepare-deployment.bat ^> Choisir option 2
echo.
echo 🌊 Option 3 - DigitalOcean (payant mais fiable) :
echo    .\prepare-deployment.bat ^> Choisir option 3

echo.
set /p open_railway="🌐 Ouvrir Railway dashboard maintenant ? (o/n) : "
if /i "%open_railway%"=="o" (
    start https://railway.app/dashboard
)

echo.
echo 💡 CONSEILS POUR DÉBUGGER :
echo ===========================
echo 1. Regardez les logs de build Railway en temps réel
echo 2. L'erreur sera visible dans "Deployments" ^> "View Logs"
echo 3. Les erreurs courantes :
echo    - "composer install failed" → Problème de dépendances
echo    - "Class not found" → Problème d'autoload
echo    - "Connection refused" → Base de données non configurée

pause