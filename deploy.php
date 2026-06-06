<?php

// Script de déploiement automatique

echo "🚀 Déploiement en cours...\n";

// 1. Vérifications
if (!file_exists('composer.json')) {
    die("❌ Erreur : composer.json non trouvé\n");
}

// 2. Installation des dépendances
echo "📦 Installation des dépendances...\n";
exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $return);
if ($return !== 0) {
    die("❌ Erreur lors de l'installation des dépendances\n");
}

// 3. Optimisation Laravel
echo "⚡ Optimisation de Laravel...\n";
exec('php artisan config:cache 2>&1');
exec('php artisan route:cache 2>&1');
exec('php artisan view:cache 2>&1');

// 4. Migrations
echo "🗄️ Exécution des migrations...\n";
exec('php artisan migrate --force 2>&1');

// 5. Seeding (optionnel)
if (getenv('SEED_DATABASE') === 'true') {
    echo "🌱 Insertion des données de test...\n";
    exec('php artisan db:seed --force 2>&1');
}

// 6. Stockage
echo "📁 Configuration du stockage...\n";
exec('php artisan storage:link 2>&1');

// 7. Optimisation finale
exec('php artisan optimize 2>&1');

echo "✅ Déploiement terminé avec succès !\n";
echo "🌐 Votre blog social est maintenant en ligne !\n";