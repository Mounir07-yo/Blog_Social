@echo off
echo ================================================
echo   TEST FONCTIONNALITÉ MOT DE PASSE OUBLIÉ
echo ================================================

echo.
echo 🔍 Vérification de la configuration...
php -r "
echo 'Configuration email actuelle:' . PHP_EOL;
echo 'MAIL_MAILER: ' . env('MAIL_MAILER', 'non défini') . PHP_EOL;
echo 'MAIL_HOST: ' . env('MAIL_HOST', 'non défini') . PHP_EOL;
echo 'MAIL_PORT: ' . env('MAIL_PORT', 'non défini') . PHP_EOL;
echo PHP_EOL;
"

echo.
echo 📋 MÉTHODES DE TEST DISPONIBLES :
echo.
echo [1] Voir les emails dans les logs Laravel (mode log)
echo [2] Utiliser MailHog (serveur email local)
echo [3] Tester avec Gmail (nécessite configuration)
echo [4] Afficher le lien directement (mode développement)
echo.
set /p choice="Choisissez une méthode (1-4): "

if "%choice%"=="1" (
    echo.
    echo 📧 MODE LOG - Les emails sont dans storage/logs/laravel.log
    echo.
    echo 1. Allez sur : http://127.0.0.1:8000/forgot-password
    echo 2. Saisissez : admin@blog.com
    echo 3. Puis exécutez cette commande pour voir l'email :
    echo.
    echo    type storage\logs\laravel.log | findstr "password-reset"
    echo.
    
) else if "%choice%"=="2" (
    echo.
    echo 📧 MODE MAILHOG
    echo.
    echo Étapes :
    echo 1. Téléchargez MailHog : https://github.com/mailhog/MailHog/releases
    echo 2. Lancez mailhog.exe
    echo 3. Allez sur http://127.0.0.1:8025 pour voir l'interface
    echo 4. Testez sur http://127.0.0.1:8000/forgot-password
    echo.
    set /p startmailhog="Ouvrir l'interface MailHog maintenant ? (o/n): "
    if /i "%startmailhog%"=="o" (
        start http://127.0.0.1:8025
    )
    
) else if "%choice%"=="3" (
    echo.
    echo 📧 MODE GMAIL
    echo.
    echo Configuration nécessaire dans .env :
    echo MAIL_MAILER=smtp
    echo MAIL_HOST=smtp.gmail.com
    echo MAIL_PORT=587
    echo MAIL_USERNAME=votre.email@gmail.com
    echo MAIL_PASSWORD=mot_de_passe_application_gmail
    echo MAIL_ENCRYPTION=tls
    echo.
    echo ⚠️  Attention : Utilisez un mot de passe d'application Gmail !
    echo Guide : https://support.google.com/accounts/answer/185833
    
) else if "%choice%"=="4" (
    echo.
    echo 🔧 MODE DÉVELOPPEMENT - Affichage direct du lien
    echo.
    echo Test automatique...
    php artisan tinker --execute="
    use App\Models\User;
    use App\Mail\PasswordResetMail;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Hash;
    
    echo 'Création d\'un token de test...' . PHP_EOL;
    
    \$user = User::where('email', 'admin@blog.com')->first();
    if (!\$user) {
        echo 'Utilisateur admin@blog.com non trouvé !' . PHP_EOL;
        exit;
    }
    
    \$token = Str::random(60);
    \DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => \$user->email],
        ['token' => Hash::make(\$token), 'created_at' => now()]
    );
    
    \$resetUrl = url('/reset-password/' . \$token . '?email=' . urlencode(\$user->email));
    echo 'LIEN DE RÉINITIALISATION :' . PHP_EOL;
    echo \$resetUrl . PHP_EOL;
    echo PHP_EOL;
    echo 'Copiez ce lien et collez-le dans votre navigateur pour tester !' . PHP_EOL;
    "
)

echo.
echo 🌐 Pour tester l'interface :
echo 1. Démarrez le serveur : php artisan serve
echo 2. Allez sur : http://127.0.0.1:8000/forgot-password
echo 3. Utilisez l'email : admin@blog.com
echo.
pause