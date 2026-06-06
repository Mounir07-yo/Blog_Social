<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Créer un utilisateur de test si il n'existe pas
        $user = User::firstOrCreate(
            ['email' => 'admin@blog.com'],
            [
                'name' => 'Admin Blog',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Créer quelques articles de test
        $posts = [
            [
                'title' => 'Bienvenue sur notre blog !',
                'excerpt' => 'Découvrez ce nouveau blog et toutes les fonctionnalités qu\'il propose.',
                'content' => "Nous sommes ravis de vous accueillir sur notre nouveau blog !\n\nCe blog a été conçu pour partager des idées, des découvertes et des passions. Vous trouverez ici :\n\n- Des articles de qualité\n- Des discussions intéressantes\n- Une communauté bienveillante\n\nN'hésitez pas à vous inscrire pour publier vos propres articles et rejoindre notre communauté !",
                'featured_image' => 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Les avantages du travail collaboratif',
                'excerpt' => 'Comment le travail en équipe peut transformer votre productivité.',
                'content' => "Le travail collaboratif présente de nombreux avantages :\n\n## Partage des connaissances\nChaque membre de l'équipe apporte ses compétences uniques.\n\n## Créativité décuplée\nLa diversité des perspectives génère des idées innovantes.\n\n## Motivation renforcée\nTravailler ensemble crée une dynamique positive.\n\n## Apprentissage continu\nOn apprend constamment des autres membres de l'équipe.\n\nEn conclusion, la collaboration est un véritable moteur de succès !",
                'featured_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'L\'importance de la formation continue',
                'excerpt' => 'Pourquoi il est essentiel de continuer à apprendre tout au long de sa carrière.',
                'content' => "Dans un monde en constante évolution, la formation continue est devenue indispensable.\n\n### Pourquoi se former ?\n\n1. **Rester compétitif** : Les technologies évoluent rapidement\n2. **Développer ses compétences** : Acquérir de nouvelles aptitudes\n3. **Élargir ses horizons** : Découvrir de nouveaux domaines\n4. **Booster sa confiance** : Se sentir à jour et compétent\n\n### Comment s'y prendre ?\n\n- Suivre des formations en ligne\n- Participer à des conférences\n- Lire des livres spécialisés\n- Pratiquer régulièrement\n\nL'apprentissage est un voyage, pas une destination !",
                'featured_image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $postData) {
            Post::create(array_merge($postData, ['user_id' => $user->id]));
        }

        $this->command->info('Articles de blog créés avec succès !');
        $this->command->info('Utilisateur de test : admin@blog.com / password');
    }
}