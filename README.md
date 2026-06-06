# 🚀 Mon Blog Laravel

Un blog moderne et élégant créé avec Laravel 12. Partagez vos idées et découvrez celles des autres !

## ✨ Fonctionnalités

- 📝 **Création d'articles** - Interface intuitive pour rédiger vos articles
- 👥 **Système d'authentification** - Inscription, connexion et gestion des utilisateurs
- 🎨 **Design responsive** - Interface moderne avec Bootstrap 5
- 📱 **Mobile-friendly** - Optimisé pour tous les appareils
- 🔒 **Sécurisé** - Protection CSRF et authentification robuste
- ⚡ **Rapide** - Base de données SQLite pour des performances optimales

## 🚀 Accès rapide

**Votre blog est accessible à l'adresse :** [http://127.0.0.1:8000](http://127.0.0.1:8000)

### 🧪 Compte de test

Pour tester immédiatement toutes les fonctionnalités :

- **Email :** admin@blog.com
- **Mot de passe :** password

## 📋 Prérequis

- PHP 8.2 ou plus récent
- Composer
- SQLite (inclus avec PHP)

## ⚙️ Installation

Le projet est déjà configuré ! Si vous devez le réinstaller :

```bash
# 1. Installer les dépendances
composer install

# 2. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 3. Créer la base de données
php artisan migrate

# 4. Ajouter des données de test
php artisan db:seed

# 5. Lancer le serveur
php artisan serve
```

## 🎯 Utilisation

### Pour les visiteurs
1. Visitez [http://127.0.0.1:8000](http://127.0.0.1:8000)
2. Parcourez les articles sur `/blog`
3. Inscrivez-vous pour publier vos propres articles

### Pour les auteurs
1. Connectez-vous avec votre compte
2. Cliquez sur "Écrire un article"
3. Rédigez votre contenu
4. Publiez ou sauvegardez en brouillon

## 📁 Structure du projet

```
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php     # Authentification
│   │   └── PostController.php     # Gestion des articles
│   └── Models/
│       ├── User.php               # Modèle utilisateur
│       └── Post.php               # Modèle article
├── database/
│   ├── migrations/                # Structure de la base
│   └── seeders/                   # Données de test
├── resources/views/
│   ├── auth/                      # Pages d'authentification
│   ├── blog/                      # Pages du blog
│   └── layouts/                   # Templates
└── routes/
    └── web.php                    # Routes de l'application
```

## 🎨 Fonctionnalités du blog

### Articles
- ✍️ Création avec titre, résumé et contenu
- 🖼️ Image de couverture (URL)
- 📝 Mode brouillon ou publication directe
- ✏️ Modification et suppression par l'auteur
- 🔗 URLs conviviales (slugs)

### Authentification
- 📧 Inscription avec email et mot de passe
- 🔐 Connexion sécurisée
- 👤 Gestion de profil utilisateur
- 🔒 Protection des actions d'écriture

### Interface
- 🎨 Design moderne avec Bootstrap 5
- 📱 Responsive sur mobile et desktop
- 🌈 Animations CSS élégantes
- 🔍 Navigation intuitive

## 🛠️ Développement

### Commandes utiles

```bash
# Lancer le serveur de développement
php artisan serve

# Créer un nouvel article via tinker
php artisan tinker

# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Voir les routes
php artisan route:list
```

### Ajouter des fonctionnalités

Le code est structuré pour être facilement extensible :

- **Nouveaux modèles** : `php artisan make:model NomModele -mcr`
- **Nouvelles vues** : Ajoutez dans `resources/views/`
- **Nouveaux contrôleurs** : `php artisan make:controller NomController`

## 🎉 Prêt à bloguer !

Votre blog est maintenant opérationnel. Visitez [http://127.0.0.1:8000](http://127.0.0.1:8000) et commencez à partager vos idées !

### Prochaines étapes suggérées :

1. 🎨 Personnalisez le design dans `resources/views/layouts/app.blade.php`
2. 📝 Ajoutez des catégories aux articles
3. 💬 Implémentez un système de commentaires
4. 🔍 Ajoutez une fonction de recherche
5. 📊 Créez un tableau de bord administrateur

---

**Créé avec ❤️ et Laravel** | [Documentation Laravel](https://laravel.com/docs)