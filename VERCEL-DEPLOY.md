# 🚀 Déploiement VERCEL + PLANETSCALE - AREX

**Vercel est souvent plus fiable que Railway !** Voici comment déployer AREX en 10 minutes.

## 🎯 Pourquoi Vercel ?

✅ **100% GRATUIT** (même en production)  
✅ **Performance mondiale** (CDN Cloudflare)  
✅ **Déploiement automatique** GitHub  
✅ **Moins de bugs** que Railway  
✅ **Support excellent**  

---

## 📋 ÉTAPE 1 : Base de Données PlanetScale

### 1.1 Créer le compte
1. 🌐 Allez sur : https://planetscale.com
2. 🔐 Inscrivez-vous avec GitHub (gratuit)
3. ➕ Créez une nouvelle database : **`arex-db`**

### 1.2 Obtenir la connection string
1. 📊 Dashboard PlanetScale → votre database
2. 🔌 "Connect" → "Connect with" → **Prisma/Laravel**
3. 📋 Copiez la `DATABASE_URL` qui ressemble à :
   ```
   mysql://username:password@host.planetscale.com/arex-db?sslaccept=strict
   ```

---

## 📋 ÉTAPE 2 : Hébergement Vercel

### 2.1 Importer le projet
1. 🌐 Allez sur : https://vercel.com
2. 🔐 Connectez-vous avec GitHub
3. ➕ "New Project" → "Import Git Repository"
4. 🎯 Sélectionnez : **Blog_Social**

### 2.2 Configuration du projet
1. **Framework Preset** : `Other` (pas Laravel - Vercel gère différemment)
2. **Root Directory** : `./` (racine)
3. **Build Command** : `composer install --no-dev --optimize-autoloader`
4. **Output Directory** : `public`
5. **Install Command** : (laisser vide)

---

## 📋 ÉTAPE 3 : Variables d'Environnement

Dans Vercel → Settings → Environment Variables, ajoutez :

```bash
# Base de données
DATABASE_URL=mysql://username:password@host.planetscale.com/arex-db?sslaccept=strict

# Application Laravel
APP_NAME=AREX
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:J3O89zeuZG/iZK+685+NYfdNrOaTnUSMrRa+ldc+rQs=
APP_URL=https://votre-projet.vercel.app

# Cache et sessions (important pour Vercel)
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Logs
LOG_CHANNEL=stack
LOG_LEVEL=error

# Sécurité
BCRYPT_ROUNDS=10
```

---

## 📋 ÉTAPE 4 : Configuration Vercel

### 4.1 Créer vercel.json
Créez ce fichier à la racine du projet :

```json
{
  "version": 2,
  "builds": [
    {
      "src": "public/index.php",
      "use": "vercel-php@0.5.2"
    }
  ],
  "routes": [
    {
      "src": "/(.*)",
      "dest": "public/index.php"
    }
  ],
  "env": {
    "APP_ENV": "production",
    "APP_DEBUG": "false"
  }
}
```

### 4.2 Optimiser pour Vercel
Dans `composer.json`, ajoutez dans scripts :

```json
"scripts": {
    "vercel-build": [
        "composer install --no-dev --optimize-autoloader",
        "@php artisan config:cache",
        "@php artisan route:cache",
        "@php artisan view:cache"
    ]
}
```

---

## 🚀 DÉPLOIEMENT

### Push les changements
```bash
git add .
git commit -m "🚀 Vercel deployment configuration"
git push
```

### Vercel déploie automatiquement !
- 📊 Surveillez le dashboard Vercel
- ⏱️ Build time : ~2-3 minutes
- 🎉 URL finale : `https://blog-social-xxx.vercel.app`

---

## 🔧 Configuration Post-Déploiement

### 1. Base de données
Vercel ne peut pas exécuter les migrations automatiquement. Options :

#### Option A : PlanetScale CLI (recommandé)
```bash
# Installer PlanetScale CLI
npm install -g @planetscale/cli

# Se connecter
pscale auth login

# Créer les tables (schema push)
pscale database create arex-db
```

#### Option B : Exporter depuis local
```bash
# Exporter votre base locale
mysqldump -u root blog_social > arex-schema.sql

# Importer sur PlanetScale via interface web
```

### 2. Variables manquantes
Si erreurs, ajoutez dans Vercel :
```bash
TRUSTED_PROXIES=*
ASSET_URL=https://votre-projet.vercel.app
```

---

## 🎯 AVANTAGES vs RAILWAY

| Feature | Vercel | Railway |
|---------|--------|---------|
| 🆓 Gratuit | ✅ Toujours | ✅ 500h/mois |
| 🚀 Performance | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| 🔧 Simplicité | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| 🐛 Bugs Build | ⭐⭐⭐⭐⭐ | ⭐⭐ |
| 💾 Base données | PlanetScale | MySQL inclus |
| 🌍 CDN Global | ✅ | ❌ |

---

## 🆘 Dépannage

### ❌ Build Failed
- Vérifiez `vercel.json` syntaxe
- Build command correct : `composer install --no-dev`

### ❌ Database Connection
- Vérifiez `DATABASE_URL` dans variables Vercel
- Testez connexion PlanetScale

### ❌ 500 Error
- Ajoutez `APP_KEY` dans variables
- Vérifiez logs Vercel dashboard

### ❌ Assets not loading
- Ajoutez `ASSET_URL=https://votre-url.vercel.app`
- Vérifiez `public/` directory config

---

## 🎊 Résultat Final

✅ **AREX en ligne** : `https://votre-projet.vercel.app`  
✅ **Performance mondiale** avec CDN  
✅ **Base MySQL** serverless et gratuite  
✅ **Déploiement automatique** à chaque git push  
✅ **HTTPS + Domaine personnalisé** gratuit  

**Coût total : 0€/mois** 💸

---

## 🔗 Liens Utiles

- 📊 **Vercel Dashboard** : https://vercel.com/dashboard
- 💾 **PlanetScale Dashboard** : https://planetscale.com/dashboard  
- 📖 **Vercel Docs** : https://vercel.com/docs
- 🛟 **Support Vercel** : https://vercel.com/help

**Vercel + PlanetScale = Combo imbattable pour Laravel ! 🚀**