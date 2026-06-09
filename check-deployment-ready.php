<?php

echo "=== VÉRIFICATION DE L'ÉTAT DE DÉPLOIEMENT ===\n\n";

$checks = [];

// 1. Vérifier Laravel
if (file_exists('artisan')) {
    $checks['laravel'] = '✅ Projet Laravel détecté';
} else {
    $checks['laravel'] = '❌ Fichier artisan manquant';
}

// 2. Vérifier Composer
if (file_exists('composer.json') && file_exists('vendor')) {
    $checks['composer'] = '✅ Dépendances Composer installées';
} else {
    $checks['composer'] = '⚠️ Exécutez: composer install';
}

// 3. Vérifier Git
if (file_exists('.git')) {
    $checks['git'] = '✅ Repository Git initialisé';
    
    // Vérifier remote
    $remote = shell_exec('git remote get-url origin 2>NUL');
    if ($remote) {
        $checks['git_remote'] = '✅ Remote GitHub configurée: ' . trim($remote);
    } else {
        $checks['git_remote'] = '⚠️ Remote GitHub non configurée';
    }
    
    // Vérifier status
    $status = shell_exec('git status --porcelain 2>NUL');
    if (empty(trim($status))) {
        $checks['git_status'] = '✅ Aucun fichier non commité';
    } else {
        $checks['git_status'] = '⚠️ Fichiers non commités détectés';
    }
} else {
    $checks['git'] = '❌ Repository Git non initialisé';
}

// 4. Vérifier fichiers de déploiement
if (file_exists('railway.json')) {
    $checks['railway_config'] = '✅ railway.json présent';
} else {
    $checks['railway_config'] = '⚠️ railway.json manquant (sera créé)';
}

if (file_exists('.env.production')) {
    $checks['env_prod'] = '✅ .env.production présent';
} else {
    $checks['env_prod'] = '⚠️ .env.production manquant (sera créé)';
}

if (file_exists('Procfile')) {
    $checks['procfile'] = '✅ Procfile présent';
} else {
    $checks['procfile'] = '⚠️ Procfile manquant (optionnel pour Railway)';
}

// 5. Vérifier la base de données locale
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    \DB::connection()->getPdo();
    $checks['database'] = '✅ Connexion base de données locale OK';
    
    // Vérifier les tables importantes
    $tables = ['users', 'posts', 'comments', 'messages'];
    $missingTables = [];
    
    foreach ($tables as $table) {
        if (!\Schema::hasTable($table)) {
            $missingTables[] = $table;
        }
    }
    
    if (empty($missingTables)) {
        $checks['tables'] = '✅ Toutes les tables essentielles présentes';
    } else {
        $checks['tables'] = '⚠️ Tables manquantes: ' . implode(', ', $missingTables);
    }
    
    // Vérifier utilisateur admin
    $admin = \App\Models\User::where('email', 'admin@blog.com')->first();
    if ($admin && $admin->is_admin) {
        $checks['admin'] = '✅ Utilisateur admin configuré';
    } else {
        $checks['admin'] = '⚠️ Utilisateur admin manquant';
    }
    
} catch (Exception $e) {
    $checks['database'] = '❌ Erreur base de données: ' . $e->getMessage();
}

// 6. Vérifier les permissions
if (is_writable('storage')) {
    $checks['storage'] = '✅ Dossier storage accessible en écriture';
} else {
    $checks['storage'] = '❌ Problème de permissions sur storage/';
}

if (is_writable('bootstrap/cache')) {
    $checks['cache'] = '✅ Dossier cache accessible en écriture';
} else {
    $checks['cache'] = '❌ Problème de permissions sur bootstrap/cache/';
}

// Affichage des résultats
echo "🔍 RÉSULTATS DE LA VÉRIFICATION :\n";
echo str_repeat("=", 50) . "\n\n";

$ready = true;
foreach ($checks as $category => $result) {
    echo "$result\n";
    if (strpos($result, '❌') !== false) {
        $ready = false;
    }
}

echo "\n" . str_repeat("=", 50) . "\n";

if ($ready) {
    echo "🎉 VOTRE BLOG EST PRÊT POUR LE DÉPLOIEMENT !\n\n";
    echo "🚀 ÉTAPES SUIVANTES :\n";
    echo "1. Exécutez: .\\deploy-to-railway.bat\n";
    echo "2. Suivez les instructions pour Railway\n";
    echo "3. Votre blog sera en ligne en 5 minutes !\n\n";
} else {
    echo "⚠️ QUELQUES AJUSTEMENTS SONT NÉCESSAIRES\n\n";
    echo "🔧 SOLUTIONS :\n";
    
    if (strpos($checks['composer'] ?? '', '⚠️') !== false) {
        echo "- Exécutez: composer install\n";
    }
    if (strpos($checks['git'] ?? '', '❌') !== false) {
        echo "- Exécutez: git init && git add . && git commit -m \"Initial commit\"\n";
    }
    if (strpos($checks['database'] ?? '', '❌') !== false) {
        echo "- Exécutez: php create-tables.php\n";
    }
    if (strpos($checks['storage'] ?? '', '❌') !== false) {
        echo "- Vérifiez les permissions du dossier storage/\n";
    }
    
    echo "\n🔄 Puis relancez cette vérification !\n\n";
}

// Informations sur les plateformes
echo "📊 PLATEFORMES D'HÉBERGEMENT RECOMMANDÉES :\n";
echo str_repeat("-", 50) . "\n";
echo "🚂 Railway     : GRATUIT, 500h/mois, MySQL inclus\n";
echo "▲ Vercel      : GRATUIT, performance max, + PlanetScale\n";  
echo "🌊 DigitalOcean: 5$/mois, professionnel, scaling auto\n";
echo "☁️ Cloudflare  : 1$/mois, ultra rapide, avancé\n\n";

echo "🏆 RECOMMANDATION : Commencez avec Railway (gratuit + simple)\n\n";

?>