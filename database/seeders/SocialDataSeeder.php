<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Hash;

class SocialDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Créer des utilisateurs supplémentaires
        $users = [
            [
                'name' => 'Marie Dupont',
                'email' => 'marie@blog.com',
                'password' => Hash::make('password'),
                'bio' => 'Passionnée de technologie et d\'innovation. J\'aime partager mes découvertes !',
                'location' => 'Paris, France',
                'avatar' => 'https://ui-avatars.com/api/?name=Marie+Dupont&background=e91e63&color=fff&size=200',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre@blog.com',
                'password' => Hash::make('password'),
                'bio' => 'Développeur full-stack et créateur de contenu. Toujours en quête de nouveaux défis !',
                'location' => 'Lyon, France',
                'website' => 'https://pierremartin.dev',
                'avatar' => 'https://ui-avatars.com/api/?name=Pierre+Martin&background=4caf50&color=fff&size=200',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie@blog.com',
                'password' => Hash::make('password'),
                'bio' => 'UX Designer & consultante. J\'aide les entreprises à créer de meilleures expériences utilisateur.',
                'location' => 'Bordeaux, France',
                'avatar' => 'https://ui-avatars.com/api/?name=Sophie+Bernard&background=9c27b0&color=fff&size=200',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        $allUsers = User::all();
        $adminUser = User::where('email', 'admin@blog.com')->first();

        // Créer des articles supplémentaires
        $posts = [
            [
                'title' => 'Les tendances du développement web en 2026',
                'excerpt' => 'Découvrez les technologies et frameworks qui façonnent le web moderne.',
                'content' => "Le développement web évolue rapidement et 2026 apporte son lot de nouveautés passionnantes !\n\n## Les frameworks JavaScript\n\nLes frameworks comme React, Vue.js et Angular continuent d'évoluer avec de nouvelles fonctionnalités.\n\n## L'intelligence artificielle\n\nL'IA s'intègre de plus en plus dans nos applications web, offrant des expériences utilisateur personnalisées.\n\n## La performance\n\nLa vitesse et l'optimisation restent des priorités absolues pour une expérience utilisateur optimale.\n\nQue pensez-vous de ces tendances ? Partagez votre avis en commentaire !",
                'featured_image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => now()->subHours(3),
                'user_id' => $allUsers->where('email', 'pierre@blog.com')->first()->id,
            ],
            [
                'title' => 'Comment créer une expérience utilisateur exceptionnelle',
                'excerpt' => 'Les principes fondamentaux du design UX pour captiver vos utilisateurs.',
                'content' => "L'expérience utilisateur (UX) est au cœur de tout produit digital réussi.\n\n### 1. Comprendre vos utilisateurs\n\nCommencez toujours par étudier votre audience cible. Leurs besoins, leurs frustrations, leurs habitudes.\n\n### 2. Simplifier l'interface\n\nMoins il y a d'éléments à l'écran, plus l'utilisateur peut se concentrer sur l'essentiel.\n\n### 3. Tester et itérer\n\nLe design parfait n'existe pas du premier coup. Il faut tester, collecter des retours et améliorer constamment.\n\n### 4. Accessibilité\n\nPensez à tous les utilisateurs, y compris ceux en situation de handicap.\n\nL'UX, c'est avant tout de l'empathie mise en pratique !",
                'featured_image' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => now()->subHours(5),
                'user_id' => $allUsers->where('email', 'sophie@blog.com')->first()->id,
            ],
            [
                'title' => 'Mes 5 outils préférés pour la productivité',
                'excerpt' => 'Une sélection d\'applications qui transforment ma façon de travailler.',
                'content' => "En tant que passionnée de tech, j'ai testé de nombreux outils. Voici mes favoris :\n\n## 1. Notion\n\nPour organiser mes idées, projets et notes. Un vrai couteau suisse de la productivité !\n\n## 2. Figma\n\nIndispensable pour le design collaboratif. L'interface est intuitive et les fonctionnalités sont puissantes.\n\n## 3. Todoist\n\nPour gérer mes tâches avec intelligence. Les rappels automatiques sont un plus !\n\n## 4. Loom\n\nPour créer des vidéos explicatives rapidement. Parfait pour le travail à distance.\n\n## 5. GitHub\n\nEt oui, même pour les non-développeurs ! Je l'utilise pour versionner mes documents.\n\nEt vous, quels sont vos outils indispensables ?",
                'featured_image' => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=800&h=400&fit=crop',
                'is_published' => true,
                'published_at' => now()->subHour(),
                'user_id' => $allUsers->where('email', 'marie@blog.com')->first()->id,
            ]
        ];

        foreach ($posts as $postData) {
            Post::firstOrCreate(['title' => $postData['title']], $postData);
        }

        // Créer des commentaires
        $allPosts = Post::all();
        
        $comments = [
            [
                'content' => 'Excellent article ! J\'ai hâte de tester ces nouvelles technologies.',
                'user_id' => $adminUser->id,
                'post_id' => $allPosts->where('title', 'Les tendances du développement web en 2026')->first()->id,
            ],
            [
                'content' => 'Merci pour ces conseils pratiques. L\'UX est vraiment essentielle aujourd\'hui.',
                'user_id' => $allUsers->where('email', 'pierre@blog.com')->first()->id,
                'post_id' => $allPosts->where('title', 'Comment créer une expérience utilisateur exceptionnelle')->first()->id,
            ],
            [
                'content' => 'Notion est effectivement fantastique ! Je l\'utilise quotidiennement.',
                'user_id' => $allUsers->where('email', 'sophie@blog.com')->first()->id,
                'post_id' => $allPosts->where('title', 'Mes 5 outils préférés pour la productivité')->first()->id,
            ],
        ];

        foreach ($comments as $commentData) {
            Comment::create($commentData);
        }

        // Créer des likes
        foreach ($allPosts as $post) {
            // Chaque utilisateur like aléatoirement les articles
            foreach ($allUsers->random(rand(1, $allUsers->count())) as $user) {
                Like::firstOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $post->id,
                    'likeable_type' => Post::class,
                ]);
            }
        }

        // Créer des relations de suivi
        $marie = $allUsers->where('email', 'marie@blog.com')->first();
        $pierre = $allUsers->where('email', 'pierre@blog.com')->first();
        $sophie = $allUsers->where('email', 'sophie@blog.com')->first();

        // Marie suit Pierre et Sophie
        $marie->following()->syncWithoutDetaching([$pierre->id, $sophie->id]);
        
        // Pierre suit Sophie et Admin
        $pierre->following()->syncWithoutDetaching([$sophie->id, $adminUser->id]);
        
        // Sophie suit Marie et Admin
        $sophie->following()->syncWithoutDetaching([$marie->id, $adminUser->id]);
        
        // Admin suit tout le monde
        $adminUser->following()->syncWithoutDetaching([$marie->id, $pierre->id, $sophie->id]);

        $this->command->info('Données sociales créées avec succès !');
        $this->command->info('Utilisateurs de test :');
        $this->command->info('- admin@blog.com / password');
        $this->command->info('- marie@blog.com / password');
        $this->command->info('- pierre@blog.com / password'); 
        $this->command->info('- sophie@blog.com / password');
    }
}