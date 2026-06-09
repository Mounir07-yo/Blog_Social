<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "=== CREATION DES TABLES MANQUANTES ===\n\n";

try {
    // Vérifier la connexion à la base de données
    DB::connection()->getPdo();
    echo "✓ Connexion à la base de données réussie\n\n";
    
    // Créer la table messages si elle n'existe pas
    if (!Schema::hasTable('messages')) {
        echo "Création de la table 'messages'...\n";
        
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Index pour optimiser les requêtes
            $table->index(['sender_id', 'receiver_id']);
            $table->index(['receiver_id', 'is_read']);
        });
        
        echo "✓ Table 'messages' créée avec succès\n";
    } else {
        echo "✓ Table 'messages' existe déjà\n";
    }
    
    // Créer la table password_reset_tokens si elle n'existe pas
    if (!Schema::hasTable('password_reset_tokens')) {
        echo "Création de la table 'password_reset_tokens'...\n";
        
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        
        echo "✓ Table 'password_reset_tokens' créée avec succès\n";
    } else {
        echo "✓ Table 'password_reset_tokens' existe déjà\n";
    }
    
    // Vérifier/créer l'utilisateur admin
    echo "\nVérification de l'utilisateur admin...\n";
    
    $admin = DB::table('users')->where('email', 'admin@blog.com')->first();
    
    if (!$admin) {
        echo "Création de l'utilisateur admin...\n";
        
        DB::table('users')->insert([
            'name' => 'Administrateur',
            'email' => 'admin@blog.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "✓ Utilisateur admin créé (admin@blog.com / password)\n";
    } else {
        echo "✓ Utilisateur admin existe déjà\n";
        
        // S'assurer qu'il est admin
        if (!$admin->is_admin) {
            DB::table('users')
                ->where('email', 'admin@blog.com')
                ->update(['is_admin' => true]);
            echo "✓ Droits admin accordés à admin@blog.com\n";
        }
    }
    
    echo "\n=== TOUTES LES TABLES SONT PRETES ===\n";
    echo "✓ Base de données configurée\n";
    echo "✓ Tables messages et password_reset_tokens disponibles\n";
    echo "✓ Utilisateur admin : admin@blog.com / password\n";
    echo "✓ Vous pouvez maintenant utiliser le blog et la messagerie\n\n";
    
    echo "Accédez au blog : http://127.0.0.1:8000\n";
    
} catch (Exception $e) {
    echo "❌ ERREUR : " . $e->getMessage() . "\n";
    echo "\nVérifiez :\n";
    echo "1. Que XAMPP est démarré\n";
    echo "2. Que MySQL fonctionne\n";
    echo "3. Que la base de données 'blog_social' existe\n";
    echo "4. Les paramètres de connexion dans le fichier .env\n";
    exit(1);
}

?>