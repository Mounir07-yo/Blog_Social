Write-Host "================================================" -ForegroundColor Blue
Write-Host "   CONFIGURATION DU BLOG LARAVEL" -ForegroundColor Blue
Write-Host "================================================" -ForegroundColor Blue
Write-Host ""

# Étape 1 : Vérification de PHP
Write-Host "Étape 1 : Vérification de PHP..." -ForegroundColor Yellow
try {
    $phpVersion = php --version 2>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ PHP est disponible" -ForegroundColor Green
    } else {
        throw "PHP non disponible"
    }
} catch {
    Write-Host "❌ PHP n'est pas disponible" -ForegroundColor Red
    Write-Host ""
    Write-Host "SOLUTION :" -ForegroundColor Yellow
    Write-Host "1. Démarrez XAMPP" -ForegroundColor White
    Write-Host "2. Ajoutez PHP au PATH ou utilisez le PHP de XAMPP" -ForegroundColor White
    Write-Host "3. Relancez ce script" -ForegroundColor White
    Write-Host ""
    Read-Host "Appuyez sur Entrée pour continuer"
    exit 1
}

Write-Host ""

# Étape 2 : Test de connexion à la base de données
Write-Host "Étape 2 : Test de connexion à la base de données..." -ForegroundColor Yellow
try {
    $testConnection = php -r "
    try {
        `$pdo = new PDO('mysql:host=127.0.0.1;dbname=blog_social', 'root', '');
        echo 'OK';
    } catch (Exception `$e) {
        echo 'ERREUR: ' . `$e->getMessage();
        exit(1);
    }
    " 2>$null
    
    if ($testConnection -eq 'OK') {
        Write-Host "✓ Connexion à la base de données réussie" -ForegroundColor Green
    } else {
        throw $testConnection
    }
} catch {
    Write-Host "❌ Impossible de se connecter à la base de données" -ForegroundColor Red
    Write-Host ""
    Write-Host "SOLUTIONS :" -ForegroundColor Yellow
    Write-Host "1. Démarrez XAMPP et MySQL" -ForegroundColor White
    Write-Host "2. Créez la base de données 'blog_social' via phpMyAdmin" -ForegroundColor White
    Write-Host "3. Vérifiez les paramètres dans le fichier .env" -ForegroundColor White
    Write-Host ""
    $choice = Read-Host "Voulez-vous ouvrir phpMyAdmin ? (O/N)"
    if ($choice -eq 'O' -or $choice -eq 'o') {
        Start-Process "http://localhost/phpmyadmin"
    }
    Read-Host "Appuyez sur Entrée pour continuer"
    exit 1
}

Write-Host ""

# Étape 3 : Création des tables
Write-Host "Étape 3 : Création des tables avec PHP..." -ForegroundColor Yellow
try {
    php create-tables.php
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Tables créées avec succès" -ForegroundColor Green
    } else {
        throw "Erreur lors de la création des tables"
    }
} catch {
    Write-Host "❌ Erreur lors de la création des tables" -ForegroundColor Red
    Write-Host "Consultez le fichier instructions-xampp.md pour une création manuelle" -ForegroundColor Yellow
    Read-Host "Appuyez sur Entrée pour continuer"
    exit 1
}

Write-Host ""

# Étape 4 : Nettoyage du cache
Write-Host "Étape 4 : Nettoyage du cache..." -ForegroundColor Yellow
php artisan config:clear 2>$null
php artisan route:clear 2>$null  
php artisan view:clear 2>$null
Write-Host "✓ Cache nettoyé" -ForegroundColor Green

Write-Host ""
Write-Host "================================================" -ForegroundColor Green
Write-Host "   🎉 CONFIGURATION TERMINÉE AVEC SUCCÈS !" -ForegroundColor Green  
Write-Host "================================================" -ForegroundColor Green
Write-Host ""

Write-Host "✅ FONCTIONNALITÉS DISPONIBLES :" -ForegroundColor Green
Write-Host "  • Blog avec posts, commentaires, likes" -ForegroundColor White
Write-Host "  • Système de suivi d'utilisateurs" -ForegroundColor White
Write-Host "  • Messagerie privée entre utilisateurs" -ForegroundColor White
Write-Host "  • Système de signalement et modération" -ForegroundColor White
Write-Host "  • Réinitialisation de mot de passe" -ForegroundColor White
Write-Host "  • Gestion des timezones (Europe/Paris)" -ForegroundColor White
Write-Host ""

Write-Host "🚀 POUR DÉMARRER LE BLOG :" -ForegroundColor Cyan
Write-Host "  1. Ouvrez un nouveau terminal" -ForegroundColor White
Write-Host "  2. Tapez : php artisan serve" -ForegroundColor White
Write-Host "  3. Accédez à : http://127.0.0.1:8000" -ForegroundColor White
Write-Host ""

Write-Host "👤 COMPTES DE TEST :" -ForegroundColor Cyan
Write-Host "  • Admin : admin@blog.com / password" -ForegroundColor White
Write-Host "  • Créez d'autres comptes via la page d'inscription" -ForegroundColor White
Write-Host ""

$startServer = Read-Host "Voulez-vous démarrer le serveur maintenant ? (O/N)"
if ($startServer -eq 'O' -or $startServer -eq 'o') {
    Write-Host ""
    Write-Host "Démarrage du serveur..." -ForegroundColor Yellow
    Write-Host "Accédez à : http://127.0.0.1:8000" -ForegroundColor Cyan
    Write-Host "Appuyez sur Ctrl+C pour arrêter le serveur" -ForegroundColor Yellow
    Write-Host ""
    php artisan serve
} else {
    Write-Host ""
    Write-Host "Pour démarrer plus tard : php artisan serve" -ForegroundColor Yellow
    Read-Host "Appuyez sur Entrée pour terminer"
}