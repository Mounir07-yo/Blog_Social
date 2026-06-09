@echo off
cls
echo ================================================
echo   CONFIGURATION SIMPLE DU BLOG
echo ================================================

echo.
echo Étape 1 : Vérification de PHP...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP n'est pas disponible
    echo.
    echo SOLUTION :
    echo 1. Démarrez XAMPP
    echo 2. Ajoutez PHP au PATH ou utilisez le PHP de XAMPP
    echo 3. Relancez ce script
    echo.
    pause
    exit /b 1
)
echo ✓ PHP est disponible

echo.
echo Étape 2 : Test de connexion à la base de données...
php -r "
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=blog_social', 'root', '');
    echo 'Connexion réussie\n';
} catch (Exception $e) {
    echo 'Erreur de connexion : ' . $e->getMessage() . '\n';
    exit(1);
}
"
if %errorlevel% neq 0 (
    echo.
    echo ❌ Impossible de se connecter à la base de données
    echo.
    echo SOLUTIONS :
    echo 1. Démarrez XAMPP et MySQL
    echo 2. Créez la base de données 'blog_social' via phpMyAdmin
    echo 3. Vérifiez les paramètres dans le fichier .env
    echo.
    echo Voulez-vous ouvrir phpMyAdmin ? (O/N)
    set /p choice=
    if /i "!choice!"=="O" (
        start http://localhost/phpmyadmin
    )
    pause
    exit /b 1
)
echo ✓ Connexion à la base de données réussie

echo.
echo Étape 3 : Création des tables avec PHP...
php create-tables.php
if %errorlevel% neq 0 (
    echo.
    echo ❌ Erreur lors de la création des tables
    echo Consultez le fichier instructions-xampp.md pour une création manuelle
    pause
    exit /b 1
)

echo.
echo Étape 4 : Nettoyage du cache...
php artisan config:clear 2>nul
php artisan route:clear 2>nul
php artisan view:clear 2>nul
echo ✓ Cache nettoyé

echo.
echo ================================================
echo   🎉 CONFIGURATION TERMINÉE AVEC SUCCÈS !
echo ================================================
echo.
echo ✅ FONCTIONNALITÉS DISPONIBLES :
echo   • Blog avec posts, commentaires, likes
echo   • Système de suivi d'utilisateurs  
echo   • Messagerie privée entre utilisateurs
echo   • Système de signalement et modération
echo   • Réinitialisation sécurisée de mot de passe avec EMAIL
echo   • Gestion des timezones (Europe/Paris)
echo   • Templates d'email professionnels
echo.
echo 🚀 POUR DÉMARRER LE BLOG :
echo   1. Ouvrez un nouveau terminal
echo   2. Tapez : php artisan serve
echo   3. Accédez à : http://127.0.0.1:8000
echo.
echo 👤 COMPTES DE TEST :
echo   • Admin : admin@blog.com / password
echo   • Créez d'autres comptes via la page d'inscription
echo.
echo 📧 CONFIGURATION EMAIL :
echo   • Consultez CONFIGURATION-EMAIL.md pour configurer l'envoi d'emails
echo   • En mode développement, les liens s'affichent directement
echo   • Supports Gmail, MailHog, Mailtrap, etc.
echo.
echo 🔐 SÉCURITÉ RENFORCÉE :
echo   • Tokens cryptés et à usage unique
echo   • Expiration automatique (1h)
echo   • Emails de notification sécurisés
echo.
echo 📖 GUIDES DISPONIBLES :
echo   • GUIDE-MOT-DE-PASSE-OUBLIE.md
echo   • instructions-xampp.md
echo.
echo Voulez-vous démarrer le serveur maintenant ? (O/N)
set /p startserver=
if /i "!startserver!"=="O" (
    echo.
    echo Démarrage du serveur...
    echo Accédez à : http://127.0.0.1:8000
    echo Appuyez sur Ctrl+C pour arrêter le serveur
    echo.
    php artisan serve
) else (
    echo.
    echo Pour démarrer plus tard : php artisan serve
    pause
)