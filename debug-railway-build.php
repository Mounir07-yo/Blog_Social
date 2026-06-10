<?php

echo "=== DIAGNOSTIC RAILWAY BUILD ===\n\n";

// 1. Vérifier composer.json
echo "🔍 Vérification de composer.json...\n";
if (file_exists('composer.json')) {
    $composer = json_decode(file_get_contents('composer.json'), true);
    echo "✅ composer.json trouvé\n";
    
    // Vérifier la version PHP
    if (isset($composer['require']['php'])) {
        echo "PHP requis: " . $composer['require']['php'] . "\n";
    } else {
        echo "⚠️  Version PHP non spécifiée dans composer.json\n";
    }
    
    // Vérifier les dépendances critiques
    $criticalDeps = ['laravel/framework', 'laravel/tinker'];
    foreach ($criticalDeps as $dep) {
        if (isset($composer['require'][$dep])) {
            echo "✅ $dep: " . $composer['require'][$dep] . "\n";
        } else {
            echo "❌ $dep: manquant\n";
        }
    }
} else {
    echo "❌ composer.json manquant !\n";
}

echo "\n";

// 2. Vérifier les fichiers de build
echo "🔍 Vérification des fichiers de configuration...\n";

$buildFiles = [
    'railway.json' => 'Configuration Railway',
    'composer.lock' => 'Lock des dépendances',
    'artisan' => 'Console Laravel',
    'bootstrap/app.php' => 'Bootstrap Laravel',
    '.env.production' => 'Variables production'
];

foreach ($buildFiles as $file => $desc) {
    if (file_exists($file)) {
        echo "✅ $desc ($file)\n";
    } else {
        echo "❌ $desc ($file) - MANQUANT\n";
    }
}

echo "\n";

// 3. Vérifier railway.json
echo "🔍 Analyse de railway.json...\n";
if (file_exists('railway.json')) {
    $railway = json_decode(file_get_contents('railway.json'), true);
    if ($railway) {
        echo "✅ railway.json valide\n";
        if (isset($railway['build']['builder'])) {
            echo "Builder: " . $railway['build']['builder'] . "\n";
        }
        if (isset($railway['deploy']['startCommand'])) {
            echo "Start command: " . $railway['deploy']['startCommand'] . "\n";
        }
    } else {
        echo "❌ railway.json invalide (JSON malformé)\n";
    }
} else {
    echo "❌ railway.json manquant\n";
}

echo "\n";

// 4. Vérifier les permissions
echo "🔍 Vérification des permissions...\n";
$directories = ['storage', 'bootstrap/cache'];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "✅ $dir: accessible en écriture\n";
        } else {
            echo "⚠️  $dir: permissions limitées\n";
        }
    } else {
        echo "❌ $dir: répertoire manquant\n";
    }
}

echo "\n";

// 5. Vérifier .gitignore pour éviter les conflits
echo "🔍 Vérification de .gitignore...\n";
if (file_exists('.gitignore')) {
    $gitignore = file_get_contents('.gitignore');
    $important = ['/vendor', '/node_modules', '/.env', '/storage/*.key'];
    foreach ($important as $pattern) {
        if (strpos($gitignore, $pattern) !== false) {
            echo "✅ $pattern ignoré\n";
        } else {
            echo "⚠️  $pattern: devrait être ignoré\n";
        }
    }
} else {
    echo "❌ .gitignore manquant\n";
}

echo "\n";

// 6. Recommandations pour Railway
echo "🚀 RECOMMANDATIONS POUR RAILWAY:\n";
echo "================================\n";

echo "1. Assurez-vous que PHP 8.1+ est spécifié dans composer.json\n";
echo "2. Variables d'environnement requises sur Railway:\n";
echo "   - APP_KEY (généré automatiquement)\n";
echo "   - DATABASE_URL (généré automatiquement)\n";
echo "   - APP_ENV=production\n";
echo "   - APP_DEBUG=false\n";

echo "\n3. Commande de build suggérée:\n";
echo "   composer install --optimize-autoloader --no-dev\n";

echo "\n4. Commande de démarrage suggérée:\n";
echo "   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=\$PORT\n";

echo "\n";

// 7. Problèmes courants
echo "🐛 PROBLÈMES COURANTS ET SOLUTIONS:\n";
echo "===================================\n";

echo "❌ 'composer install failed'\n";
echo "   → Vérifiez composer.json et composer.lock\n";
echo "   → Supprimez vendor/ et refaites composer install localement\n\n";

echo "❌ 'PHP version not supported'\n";
echo "   → Ajoutez \"php\": \"^8.1\" dans composer.json require\n\n";

echo "❌ 'Class not found'\n";
echo "   → Problème d'autoload, vérifiez composer.json autoload\n\n";

echo "❌ 'Permission denied storage'\n";
echo "   → Railway gère automatiquement, pas d'action requise\n\n";

echo "❌ 'Database connection failed'\n";
echo "   → Ajoutez une base MySQL sur Railway\n";
echo "   → Railway configure DATABASE_URL automatiquement\n\n";

?>