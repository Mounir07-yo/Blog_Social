<?php
echo "Test de connexion à la base de données...\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=blog_social', 'root', '');
    echo "✓ Connexion réussie à la base de données 'blog_social'\n";
    
    // Test de la table users
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Table 'users' existe\n";
    } else {
        echo "❌ Table 'users' manquante\n";
    }
    
    // Test de la table messages
    $stmt = $pdo->query("SHOW TABLES LIKE 'messages'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Table 'messages' existe\n";
    } else {
        echo "❌ Table 'messages' manquante - sera créée\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur de connexion: " . $e->getMessage() . "\n";
    echo "\nVérifiez :\n";
    echo "1. XAMPP est démarré\n";
    echo "2. MySQL fonctionne\n"; 
    echo "3. La base de données 'blog_social' existe\n";
}
?>