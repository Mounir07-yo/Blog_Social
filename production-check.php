<?php

/**
 * 🔍 Script de vérification avant déploiement
 * Vérifie que le projet est prêt pour la production
 */

echo "🔍 === VÉRIFICATION PRE-DÉPLOIEMENT ===\n\n";

$checks = [];
$errors = [];
$warnings = [];

// 1. Vérifications des fichiers essentiels
echo "📋 Vérification des fichiers...\n";

$requiredFiles = [
    'composer.json' => 'Configuration Composer',
    'artisan' => 'CLI Laravel',
    '.env.production' => 'Configuration production',
    'Procfile' => 'Configuration serveur',
    'railway.json' => 'Configuration Railway',
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        $checks[] = "✅ $description ($file)";
    } else {
        $errors[] = "❌ $description manquant ($file)";
    }
}

// 2. Vérification de la configuration Laravel
echo "\n⚙️ Vérification Laravel...\n";

// Vérifier composer.json
if (file_exists('composer.json')) {
    $composer = json_decode(file_get_contents('composer.json'), true);
    if (isset($composer['require']['laravel/framework'])) {
        $checks[] = "✅ Laravel Framework détecté";
    }
    if (isset($composer['scripts']['deploy'])) {
        $checks[] = "✅ Script de déploiement configuré";
    } else {
        $warnings[] = "⚠️ Script de déploiement manquant";
    }
}

// 3. Vérification de la structure des dossiers
echo "\n📁 Vérification de la structure...\n";

$requiredDirs = [
    'app/Models' => 'Modèles Laravel',
    'app/Http/Controllers' => 'Contrôleurs',
    'resources/views' => 'Vues Blade',
    'database/migrations' => 'Migrations',
    'storage/app' => 'Stockage fichiers',
    'public' => 'Fichiers publics',
];

foreach ($requiredDirs as $dir => $description) {
    if (is_dir($dir)) {
        $checks[] = "✅ $description ($dir)";
    } else {
        $errors[] = "❌ $description manquant ($dir)";
    }
}

// 4. Vérification des modèles spécifiques au blog
echo "\n📊 Vérification des fonctionnalités blog...\n";

$blogFiles = [
    'app/Models/Post.php' => 'Modèle Article',
    'app/Models/Comment.php' => 'Modèle Commentaire', 
    'app/Models/Like.php' => 'Modèle Like',
    'app/Models/Follow.php' => 'Modèle Suivi',
    'app/Http/Controllers/PostController.php' => 'Contrôleur Articles',
    'app/Http/Controllers/NotificationController.php' => 'Contrôleur Notifications',
    'app/Http/Controllers/ImageUploadController.php' => 'Upload Images',
];

foreach ($blogFiles as $file => $description) {
    if (file_exists($file)) {
        $checks[] = "✅ $description";
    } else {
        $warnings[] = "⚠️ $description manquant ($file)";
    }
}

// 5. Vérification des vues
echo "\n🎨 Vérification des vues...\n";

$viewFiles = [
    'resources/views/layouts/app.blade.php' => 'Layout principal',
    'resources/views/blog/index.blade.php' => 'Page d\'accueil blog',
    'resources/views/blog/create.blade.php' => 'Création d\'article',
    'resources/views/users/show.blade.php' => 'Profil utilisateur',
    'resources/views/notifications/index.blade.php' => 'Page notifications',
];

foreach ($viewFiles as $file => $description) {
    if (file_exists($file)) {
        $checks[] = "✅ $description";
    } else {
        $warnings[] = "⚠️ $description manquant ($file)";
    }
}

// 6. Vérification de sécurité
echo "\n🔒 Vérification de sécurité...\n";

if (file_exists('.env')) {
    $env = file_get_contents('.env');
    if (strpos($env, 'APP_DEBUG=false') !== false || strpos($env, 'APP_DEBUG=true') === false) {
        $checks[] = "✅ Mode debug configuré";
    } else {
        $warnings[] = "⚠️ APP_DEBUG devrait être false en production";
    }
}

// Vérifier .gitignore
if (file_exists('.gitignore')) {
    $gitignore = file_get_contents('.gitignore');
    if (strpos($gitignore, '.env') !== false) {
        $checks[] = "✅ Fichier .env ignoré par Git";
    } else {
        $errors[] = "❌ .env doit être dans .gitignore";
    }
}

// 7. Vérification des permissions (Unix uniquement)
if (PHP_OS_FAMILY !== 'Windows') {
    echo "\n🔐 Vérification des permissions...\n";
    
    if (is_writable('storage')) {
        $checks[] = "✅ Dossier storage accessible en écriture";
    } else {
        $errors[] = "❌ Dossier storage non accessible en écriture";
    }
    
    if (is_writable('bootstrap/cache')) {
        $checks[] = "✅ Cache bootstrap accessible";
    } else {
        $errors[] = "❌ Cache bootstrap non accessible";
    }
}

// Résultats finaux
echo "\n" . str_repeat("=", 50) . "\n";
echo "📊 RAPPORT DE VÉRIFICATION\n";
echo str_repeat("=", 50) . "\n\n";

echo "✅ VÉRIFICATIONS RÉUSSIES (" . count($checks) . "):\n";
foreach ($checks as $check) {
    echo "   $check\n";
}

if (!empty($warnings)) {
    echo "\n⚠️ AVERTISSEMENTS (" . count($warnings) . "):\n";
    foreach ($warnings as $warning) {
        echo "   $warning\n";
    }
}

if (!empty($errors)) {
    echo "\n❌ ERREURS À CORRIGER (" . count($errors) . "):\n";
    foreach ($errors as $error) {
        echo "   $error\n";
    }
    echo "\n🚨 VEUILLEZ CORRIGER CES ERREURS AVANT LE DÉPLOIEMENT\n";
} else {
    echo "\n🎉 PROJET PRÊT POUR LE DÉPLOIEMENT ! 🎉\n";
    echo "\n📋 Prochaines étapes recommandées :\n";
    echo "   1. 🔄 Committez vos changements : git add . && git commit -m 'Ready for production'\n";
    echo "   2. 📤 Poussez sur GitHub : git push origin main\n";
    echo "   3. 🚂 Déployez sur Railway en suivant RAILWAY-DEPLOY.md\n";
    echo "   4. 🎊 Testez votre blog en ligne !\n";
}

echo "\n" . str_repeat("=", 50) . "\n";

// Statistiques du projet
if (function_exists('shell_exec') && PHP_OS_FAMILY !== 'Windows') {
    echo "📈 STATISTIQUES DU PROJET :\n";
    $phpFiles = shell_exec('find . -name "*.php" -not -path "./vendor/*" | wc -l');
    $bladeFiles = shell_exec('find . -name "*.blade.php" | wc -l');
    echo "   📄 Fichiers PHP : " . trim($phpFiles) . "\n";
    echo "   🎨 Templates Blade : " . trim($bladeFiles) . "\n";
}

echo "\n🚀 Bon déploiement !\n";