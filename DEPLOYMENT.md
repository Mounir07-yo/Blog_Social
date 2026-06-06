# 🚀 Guide de Déploiement - Blog Social

Ce guide vous explique comment héberger votre blog social sur différentes plateformes.

## 📋 Prérequis

- Compte GitHub (pour le code source)
- Projet Laravel fonctionnel en local

## 🆓 Option 1: Railway (GRATUIT - Recommandé)

### Étape 1: Préparer le code
```bash
# Initialiser Git si pas encore fait
git init
git add .
git commit -m "Initial commit"

# Créer un repo sur GitHub et le pousser
git remote add origin https://github.com/VOTRE_USERNAME/blog-social.git
git push -u origin main
```

### Étape 2: Déployer sur Railway
1. Allez sur [railway.app](https://railway.app)
2. Connectez-vous avec GitHub
3. Cliquez "New Project" → "Deploy from GitHub repo"
4. Sélectionnez votre repository `blog-social`
5. Railway détecte automatiquement Laravel !

### Étape 3: Configurer la base de données
1. Dans Railway, cliquez "New" → "Database" → "MySQL"
2. Copiez les variables d'environnement générées
3. Allez dans "Variables" de votre service
4. Ajoutez :
   ```
   APP_KEY=base64:VotreClefGenereeAutomatiquement=
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://votre-app.railway.app
   DB_CONNECTION=mysql
   DB_HOST=[Railway MySQL Host]
   DB_PORT=3306
   DB_DATABASE=[Railway Database Name]
   DB_USERNAME=[Railway Username]
   DB_PASSWORD=[Railway Password]
   ```

### Étape 4: Finaliser
- Railway redémarre automatiquement
- Votre blog sera accessible sur `https://votre-app.railway.app`
- Les données de test seront automatiquement créées !

## 💰 Option 2: DigitalOcean (5$/mois)

### Créer un Droplet
1. Compte DigitalOcean → Create Droplet
2. Choisir Ubuntu 22.04
3. Plan Basic 5$/mois
4. Ajouter votre clé SSH

### Installation sur le serveur
```bash
# Se connecter au serveur
ssh root@VOTRE_IP_SERVEUR

# Installer les dépendances
apt update
apt install nginx mysql-server php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-zip composer git -y

# Cloner votre projet
cd /var/www
git clone https://github.com/VOTRE_USERNAME/blog-social.git
cd blog-social

# Configuration
composer install --no-dev --optimize-autoloader
cp .env.production .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

# Permissions
chown -R www-data:www-data /var/www/blog-social
chmod -R 755 /var/www/blog-social/storage
```

### Configuration Nginx
```nginx
server {
    listen 80;
    server_name VOTRE_DOMAINE.com;
    root /var/www/blog-social/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔧 Configuration Post-Déploiement

### Variables d'environnement importantes :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Base de données
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=blog_social
DB_USERNAME=root
DB_PASSWORD=mot_de_passe_fort

# Mail (optionnel)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=mot-de-passe-app
```

## 🔒 Sécurité

### Générer une clé d'application forte :
```bash
php artisan key:generate --force
```

### Optimiser pour la production :
```bash
php artisan config:cache
php artisan route:cache  
php artisan view:cache
php artisan optimize
```

## 🌐 Nom de domaine personnalisé

1. Acheter un domaine (Namecheap, GoDaddy...)
2. Pointer les DNS vers votre serveur
3. Installer un certificat SSL gratuit avec Let's Encrypt

## 📊 Monitoring

- **Railway**: Logs automatiques dans le dashboard
- **DigitalOcean**: Installer des outils comme htop, fail2ban
- **Uptime**: Utiliser UptimeRobot pour surveiller la disponibilité

## 🆘 Dépannage

### Erreurs communes :
1. **500 Error**: Vérifiez les permissions et les logs Laravel
2. **Database Error**: Vérifiez la configuration DB dans .env
3. **Assets manquants**: Exécutez `php artisan storage:link`

### Logs :
```bash
# Railway
railway logs

# Serveur classique
tail -f storage/logs/laravel.log
```

## 📱 Test Final

Une fois déployé, testez :
1. ✅ Page d'accueil accessible
2. ✅ Inscription/Connexion
3. ✅ Création d'articles
4. ✅ Upload d'images
5. ✅ Notifications
6. ✅ Système de suivi

🎉 **Votre réseau social est maintenant en ligne !**