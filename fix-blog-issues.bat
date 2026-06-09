@echo off
echo ================================================
echo   CORRECTION DES PROBLEMES DU BLOG
echo ================================================

echo.
echo 1. Création des tables manquantes...
mysql -u root blog_social < create-messages-table.sql
if %errorlevel% neq 0 (
    echo ERREUR: Impossible de créer les tables!
    pause
    exit /b 1
)
echo ✓ Tables messages et password_reset_tokens créées avec succès!

echo.
echo 2. Vérification/création de l'utilisateur admin...
mysql -u root blog_social < create-admin-user.sql
if %errorlevel% neq 0 (
    echo ERREUR: Impossible de créer l'utilisateur admin!
    pause
    exit /b 1
)
echo ✓ Utilisateur admin vérifié!

echo.
echo 3. Nettoyage du cache Laravel...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ================================================
echo   CORRECTIONS TERMINÉES
echo ================================================
echo.
echo ✓ Problème de timezone corrigé (Europe/Paris)
echo ✓ Tables messages et password_reset_tokens créées
echo ✓ Fonctionnalité "Mot de passe oublié" ajoutée
echo ✓ Utilisateur admin vérifié
echo ✓ Cache Laravel nettoyé
echo.
echo Vous pouvez maintenant:
echo - Accéder au blog: http://127.0.0.1:8000
echo - Vous connecter en admin: admin@blog.com / password
echo - Envoyer des messages entre utilisateurs
echo - Utiliser "Mot de passe oublié" si nécessaire
echo.
pause