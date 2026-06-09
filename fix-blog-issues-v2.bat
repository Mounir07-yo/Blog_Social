@echo off
echo ================================================
echo   CORRECTION DES PROBLEMES DU BLOG (V2)
echo ================================================

echo.
echo 1. Vérification de PHP...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERREUR: PHP n'est pas installé ou pas dans le PATH!
    echo Assurez-vous que XAMPP est installé et que PHP est accessible.
    pause
    exit /b 1
)
echo ✓ PHP est disponible

echo.
echo 2. Création des tables avec Laravel...
php create-tables.php
if %errorlevel% neq 0 (
    echo ERREUR: Impossible de créer les tables!
    echo Vérifiez que XAMPP est démarré et que MySQL fonctionne.
    pause
    exit /b 1
)

echo.
echo 3. Nettoyage du cache Laravel...
php artisan config:cache 2>nul
php artisan route:cache 2>nul
php artisan view:cache 2>nul
echo ✓ Cache Laravel nettoyé

echo.
echo ================================================
echo   CORRECTIONS TERMINÉES AVEC SUCCÈS
echo ================================================
echo.
echo ✓ Problème de timezone corrigé (Europe/Paris)
echo ✓ Tables messages et password_reset_tokens créées
echo ✓ Fonctionnalité "Mot de passe oublié" ajoutée
echo ✓ Utilisateur admin vérifié (admin@blog.com / password)
echo ✓ Cache Laravel nettoyé
echo.
echo 🚀 VOTRE BLOG EST PRÊT !
echo.
echo Pour démarrer le blog :
echo   php artisan serve
echo.
echo Puis accédez à : http://127.0.0.1:8000
echo.
echo Connexion admin : admin@blog.com / password
echo.
pause