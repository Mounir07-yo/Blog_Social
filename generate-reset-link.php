<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

echo "=== GÉNÉRATEUR DE LIEN DE RÉINITIALISATION ===\n\n";

$email = $argv[1] ?? 'admin@blog.com';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ Utilisateur avec l'email '$email' non trouvé !\n";
    echo "\nUtilisateurs disponibles :\n";
    User::all()->each(function($u) {
        echo "- {$u->name} ({$u->email})\n";
    });
    exit(1);
}

echo "👤 Utilisateur trouvé : {$user->name} ({$user->email})\n\n";

// Générer un token sécurisé
$token = Str::random(60);

// Stocker le token dans la base de données
\DB::table('password_reset_tokens')->updateOrInsert(
    ['email' => $email],
    [
        'token' => Hash::make($token),
        'created_at' => now()
    ]
);

// Générer l'URL
$resetUrl = "http://127.0.0.1:8000/reset-password/{$token}?email=" . urlencode($email);

echo "🔗 LIEN DE RÉINITIALISATION GÉNÉRÉ :\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo $resetUrl . "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "📋 INSTRUCTIONS :\n";
echo "1. Copiez le lien ci-dessus\n";
echo "2. Collez-le dans votre navigateur\n";
echo "3. Créez votre nouveau mot de passe\n\n";

echo "⏰ ATTENTION :\n";
echo "- Ce lien expire dans 1 heure\n";
echo "- Il ne peut être utilisé qu'une seule fois\n\n";

echo "🚀 Vous pouvez aussi tester l'interface normale :\n";
echo "1. Allez sur : http://127.0.0.1:8000/forgot-password\n";
echo "2. Saisissez : $email\n";
echo "3. Le lien apparaîtra (mode développement)\n\n";

?>