# 🪟 Guide d'utilisation Windows

## 🚀 Démarrage rapide

### Option 1 : Script automatique (Recommandé)
Double-cliquez simplement sur `start-blog.bat` dans l'explorateur Windows.

### Option 2 : Ligne de commande
1. Ouvrez PowerShell ou l'invite de commande
2. Naviguez vers le dossier du projet
3. Exécutez : `php artisan serve`

## 🔧 Commandes Windows utiles

### Démarrage
```bat
# Démarrage avec le script
start-blog.bat

# Ou manuellement
php artisan serve
```

### Gestion de la base de données
```bat
# Réinitialiser les données
php artisan migrate:fresh --seed

# Voir les utilisateurs
php artisan tinker
>>> App\Models\User::all();
```

### Optimisation (optionnel)
```bat
# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Nettoyer le cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🌐 Accès au blog

Une fois démarré, votre blog sera accessible à :
**http://127.0.0.1:8000**

## 👤 Compte de test

- **Email :** admin@blog.com
- **Mot de passe :** password

## 🛑 Arrêter le serveur

Dans la fenêtre de commande où le serveur tourne :
- Appuyez sur `Ctrl + C`
- Ou fermez simplement la fenêtre

## 🔧 Résolution de problèmes

### Erreur "php n'est pas reconnu"
1. Vérifiez que XAMPP/PHP est installé
2. Ajoutez PHP au PATH Windows :
   - Panneau de configuration → Système → Variables d'environnement
   - Ajoutez le chemin vers PHP (ex: `C:\xampp\php`)

### Erreur "composer n'est pas reconnu"
1. Téléchargez Composer depuis getcomposer.org
2. Installez-le avec l'installateur Windows

### Port 8000 occupé
Si le port 8000 est pris, changez le port :
```bat
php artisan serve --port=8001
```
Puis accédez à http://127.0.0.1:8001

### Base de données corrompue
Supprimez le fichier `database/database.sqlite` et relancez `start-blog.bat`

## 📁 Fichiers importants Windows

- `start-blog.bat` - Script de démarrage
- `.env` - Configuration de l'application  
- `database/database.sqlite` - Base de données
- `storage/logs/` - Logs d'erreurs

## 🎯 Prochaines étapes

1. Explorez le blog sur http://127.0.0.1:8000
2. Connectez-vous avec le compte test
3. Créez votre premier article !
4. Personnalisez le design selon vos goûts

---

**Astuce Windows :** Créez un raccourci vers `start-blog.bat` sur votre bureau pour un accès rapide !