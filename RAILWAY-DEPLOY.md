# 🚂 Déploiement sur Railway - Guide Complet

Railway est la solution **GRATUITE** la plus simple pour héberger votre blog social !

## 🎯 Pourquoi Railway ?

✅ **Totalement GRATUIT** (500h/mois = toujours allumé)  
✅ **Détection automatique** de Laravel  
✅ **Base de données MySQL** incluse  
✅ **Déploiement en 1 clic**  
✅ **HTTPS automatique**  
✅ **Logs en temps réel**  

## 📋 Étape 1: Préparer votre code

### 1.1 Initialiser Git (si pas fait)
```bash
git init
git add .
git commit -m "🚀 Blog social prêt pour déploiement"
```

### 1.2 Créer un repository GitHub
1. Allez sur [github.com](https://github.com)
2. Cliquez "New repository"
3. Nom: `blog-social` ou `mon-reseau-social`
4. Public ou Private (peu importe)
5. Cliquez "Create repository"

### 1.3 Pousser le code
```bash
# Remplacez VOTRE_USERNAME par votre nom d'utilisateur GitHub
git remote add origin https://github.com/VOTRE_USERNAME/blog-social.git
git branch -M main
git push -u origin main
```

## 🚂 Étape 2: Déployer sur Railway

### 2.1 Créer un compte
1. Allez sur [railway.app](https://railway.app)
2. Cliquez "Login with GitHub"
3. Autorisez Railway à accéder à votre GitHub

### 2.2 Créer un nouveau projet
1. Cliquez "New Project"
2. Sélectionnez "Deploy from GitHub repo"
3. Choisissez votre repository `blog-social`
4. Cliquez "Deploy Now"

🎉 **Railway détecte automatiquement que c'est du Laravel !**

### 2.3 Ajouter une base de données MySQL
1. Dans votre projet Railway, cliquez "New"
2. Sélectionnez "Database" → "Add MySQL"
3. Railway crée automatiquement une base MySQL

## ⚙️ Étape 3: Configuration

### 3.1 Variables d'environnement
1. Cliquez sur votre service Laravel
2. Allez dans l'onglet "Variables"
3. Ajoutez ces variables **UNE PAR UNE** :

```env
APP_NAME=Mon Blog Social
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:SERA_GENERE_AUTOMATIQUEMENT
APP_URL=https://votre-projet-id.railway.app

DB_CONNECTION=mysql
DB_HOST=SERA_REMPLI_AUTOMATIQUEMENT
DB_PORT=3306
DB_DATABASE=SERA_REMPLI_AUTOMATIQUEMENT  
DB_USERNAME=SERA_REMPLI_AUTOMATIQUEMENT
DB_PASSWORD=SERA_REMPLI_AUTOMATIQUEMENT

CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=error
```

### 3.2 Variables de base de données automatiques
Railway va automatiquement détecter votre base MySQL et remplir :
- `DATABASE_URL` (utilisé automatiquement par Laravel)
- Ou les variables DB_* individuelles

**Vous n'avez RIEN à faire pour la DB !** 🎉

### 3.3 Génération automatique de APP_KEY
Railway exécutera automatiquement `php artisan key:generate` au déploiement.

## 🚀 Étape 4: Premier déploiement

1. Railway commence automatiquement le build
2. Vous pouvez suivre les logs en temps réel
3. Le processus prend 2-5 minutes

### Ce qui se passe automatiquement :
```bash
✅ Détection du projet Laravel
✅ Installation des dépendances (composer install)
✅ Génération de la clé APP_KEY
✅ Exécution des migrations
✅ Insertion des données de test (seeders)
✅ Configuration du stockage (storage:link)
✅ Optimisation Laravel (cache, routes, views)
```

## 🌐 Étape 5: Accéder à votre blog

1. Dans Railway, copiez l'URL générée : `https://votre-id.railway.app`
2. Votre blog social est en ligne ! 🎊

### Comptes de test disponibles :
- **admin@blog.com** / password
- **marie@blog.com** / password  
- **pierre@blog.com** / password
- **sophie@blog.com** / password

## 🔧 Maintenance et Mises à Jour

### Mettre à jour le code
```bash
# Apportez vos modifications
git add .
git commit -m "🔄 Nouvelles fonctionnalités"
git push

# Railway redéploie automatiquement !
```

### Voir les logs
1. Dans Railway → votre service → onglet "Logs"
2. Logs en temps réel pour déboguer

### Exécuter des commandes
1. Railway → votre service → "Settings"
2. Section "Environment" → Terminal (si disponible)
3. Ou utilisez les GitHub Actions pour l'automatisation

## 📊 Monitoring

### Railway Dashboard
- **CPU/RAM** : Utilisation en temps réel
- **Requêtes** : Nombre de visiteurs
- **Logs** : Erreurs et debug
- **Base de données** : Connexions MySQL

### Limites du plan gratuit
- **500h/mois** (largement suffisant pour un projet personnel)
- **500 Mo RAM** (parfait pour Laravel)
- **1 Go stockage** (suffisant pour début)

## 🆘 Dépannage

### Erreurs communes

#### 🔴 Erreur 500
```bash
# Vérifiez les logs Railway
# Souvent lié à APP_KEY manquante
```

#### 🔴 Base de données non trouvée
```bash
# Railway génère DATABASE_URL automatiquement
# Vérifiez que le service MySQL est bien connecté
```

#### 🔴 Images ne s'affichent pas
```bash
# Le stockage Railway est éphémère
# Les images uploadées peuvent disparaître au redémarrage
# Solution : utiliser un service comme AWS S3 ou Cloudinary
```

## 🎨 Personnalisation

### Nom de domaine personnalisé
1. Railway → Settings → "Domains"  
2. Ajoutez votre domaine
3. Configurez les DNS chez votre registrar

### Variables d'environnement supplémentaires
```env
# Email (optionnel)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-app-password
MAIL_FROM_ADDRESS=noreply@votre-domaine.com

# Optimisations
CACHE_STORE=database
SESSION_LIFETIME=720
BCRYPT_ROUNDS=10
```

## 🎉 Résultat Final

✅ Blog social en ligne 24/7  
✅ Base de données MySQL incluse  
✅ HTTPS automatique  
✅ Certificats SSL gratuits  
✅ Déploiements automatiques via Git  
✅ Monitoring intégré  
✅ Logs en temps réel  

**Votre réseau social est maintenant accessible au monde entier !** 🌍

---

## 🔗 Liens Utiles

- **Railway Dashboard** : [railway.app/dashboard](https://railway.app/dashboard)
- **Documentation Railway** : [docs.railway.app](https://docs.railway.app)
- **Support Railway** : [help.railway.app](https://help.railway.app)

**Coût total : 0€/mois** 💸