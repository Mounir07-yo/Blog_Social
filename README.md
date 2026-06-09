# 🌟 AREX - Réseau Social Professionnel

**AREX** est un réseau social moderne et professionnel construit avec Laravel, offrant une expérience utilisateur complète avec des fonctionnalités avancées de collaboration et de partage de contenu.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

## ✨ Fonctionnalités

### 🔐 **Authentification & Sécurité**
- ✅ Inscription/Connexion sécurisée
- ✅ Réinitialisation de mot de passe par email
- ✅ Option "Se souvenir de moi"
- ✅ Tokens de sécurité cryptés
- ✅ Protection CSRF

### 📱 **Réseau Social**
- ✅ **Posts** avec texte, images et médias multiples
- ✅ **Système de likes** sur posts et commentaires
- ✅ **Commentaires** avec réponses imbriquées
- ✅ **Suivi d'utilisateurs** (Follow/Unfollow)
- ✅ **Profils utilisateurs** personnalisables
- ✅ **Fil d'actualité** personnalisé

### 💬 **Messagerie**
- ✅ **Messages privés** entre utilisateurs
- ✅ **Interface temps réel** avec AJAX
- ✅ **Compteurs de messages non lus**
- ✅ **Historique des conversations**
- ✅ **Statuts de lecture**

### 🔔 **Notifications**
- ✅ **Notifications en temps réel**
- ✅ **Système de badges** avec compteurs
- ✅ **Notifications par email**
- ✅ **Interface dropdown** moderne

### 🛡️ **Modération & Signalements**
- ✅ **Système de signalement** complet
- ✅ **Interface administrateur** dédiée
- ✅ **Gestion des utilisateurs** (bloquer/supprimer)
- ✅ **Notifications automatiques** aux admins
- ✅ **Historique des signalements**

### 🌐 **Interface & UX**
- ✅ **Design responsive** (mobile-friendly)
- ✅ **Interface Bootstrap 5** moderne
- ✅ **Icons Font Awesome & Bootstrap Icons**
- ✅ **Animations CSS** fluides
- ✅ **Dark/Light mode** compatible

## 🚀 Installation Rapide

### Prérequis
- **PHP 8.2+**
- **Composer**
- **MySQL 8.0+**
- **Node.js** (optionnel)

### 1. Clonage et Installation
```bash
git clone https://github.com/VOTRE-USERNAME/AREX.git
cd AREX
composer install
npm install && npm run build  # Optionnel
```

### 2. Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Modifiez `.env` avec vos paramètres :
```env
APP_NAME=AREX
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_DATABASE=arex_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Base de Données
```bash
# Méthode automatique
php create-tables.php

# Ou méthode Laravel classique
php artisan migrate
php artisan db:seed
```

### 4. Démarrage
```bash
php artisan serve
```

Accédez à : **http://127.0.0.1:8000**

## 👤 Comptes de Test

| Role | Email | Mot de passe |
|------|-------|-------------|
| **Admin** | admin@blog.com | password |
| **Utilisateur** | Créez via inscription | - |

## 📧 Configuration Email

Pour la réinitialisation de mot de passe, configurez l'email dans `.env` :

```env
# Gmail (recommandé)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-app
MAIL_ENCRYPTION=tls
```

📖 Guide complet : `CONFIGURATION-EMAIL.md`

## 🌍 Hébergement

AREX est prêt pour le déploiement sur plusieurs plateformes :

### 🚂 **Railway** (Gratuit - Recommandé)
```bash
.\deploy-to-railway.bat
```
- ✅ **500h/mois gratuit**
- ✅ **MySQL inclus**
- ✅ **HTTPS automatique**

### ▲ **Vercel + PlanetScale** (Gratuit)
- Performance maximale
- Base de données serverless

### 🌊 **DigitalOcean** ($5/mois)
- Qualité professionnelle
- Scaling automatique

📖 Guide complet : `GUIDE-HEBERGEMENT-2024.md`

## 🛠️ Scripts Utiles

| Script | Description |
|--------|-------------|
| `quick-test-reset.bat` | Test mot de passe oublié |
| `check-git-status.bat` | Vérifier état Git |
| `push-to-github.bat` | Push automatique GitHub |
| `deploy-to-railway.bat` | Déploiement Railway |
| `fix-blog-simple.bat` | Réparation base de données |

## 📁 Structure du Projet

```
AREX/
├── app/
│   ├── Http/Controllers/     # Contrôleurs
│   ├── Models/              # Modèles Eloquent
│   ├── Mail/                # Templates email
│   └── Notifications/       # Notifications
├── resources/views/         # Templates Blade
├── database/migrations/     # Migrations DB
├── public/                  # Assets publics
└── routes/web.php          # Routes web
```

## 🤝 Contribution

Les contributions sont les bienvenues ! 

1. **Fork** le projet
2. **Créez** une branche feature (`git checkout -b feature/nouvelle-fonctionnalité`)
3. **Commitez** vos changements (`git commit -m 'Ajout nouvelle fonctionnalité'`)
4. **Push** vers la branche (`git push origin feature/nouvelle-fonctionnalité`)
5. **Créez** une Pull Request

## 📝 Changelog

### Version 2.0.0 (Actuelle)
- 🎨 **Rebranding complet** → AREX
- ✨ **Système de messagerie** privée
- 🔐 **Réinitialisation mot de passe** sécurisée
- 🛡️ **Système de signalements** avancé
- 🔔 **Notifications temps réel**
- 🌍 **Prêt pour production**

### Version 1.0.0
- 📝 Blog social basique
- 👥 Système d'utilisateurs
- 💬 Commentaires et likes
- 🎨 Interface Bootstrap

## 📞 Support

- 📧 **Email** : votre-email@domaine.com
- 📖 **Documentation** : `docs/`
- 🐛 **Bugs** : [GitHub Issues](https://github.com/VOTRE-USERNAME/AREX/issues)

## 📄 Licence

Ce projet est sous licence **MIT**. Voir le fichier `LICENSE` pour plus de détails.

---

<div align="center">

**🌟 AREX - Connecter • Partager • Grandir**

Fait avec ❤️ et [Laravel](https://laravel.com)

</div>