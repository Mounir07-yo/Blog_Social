@echo off
echo ================================================
echo   MIGRATION ET CONFIGURATION DU BLOG
echo ================================================

echo.
echo Exécution des migrations Laravel...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo ERREUR lors des migrations!
    echo Vérifiez que XAMPP est démarré et que la base de données existe.
    pause
    exit /b 1
)
echo ✓ Migrations exécutées

echo.
echo Création de l'utilisateur admin...
php artisan tinker --execute="
if (!App\Models\User::where('email', 'admin@blog.com')->exists()) {
    App\Models\User::create([
        'name' => 'Administrateur',
        'email' => 'admin@blog.com',
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'is_admin' => true
    ]);
    echo 'Utilisateur admin créé';
} else {
    echo 'Utilisateur admin existe déjà';
}
"

echo.
echo Nettoyage du cache...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ================================================
echo   CONFIGURATION TERMINÉE
echo ================================================
echo.
echo 🚀 Votre blog est prêt !
echo.
echo Démarrer le serveur : php artisan serve
echo Accéder au blog : http://127.0.0.1:8000
echo Connexion admin : admin@blog.com / password
echo.
pause