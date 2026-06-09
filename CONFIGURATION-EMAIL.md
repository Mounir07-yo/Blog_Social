# Configuration Email pour la Réinitialisation de Mot de Passe

Le système de réinitialisation de mot de passe est maintenant complètement sécurisé ! Voici comment configurer l'envoi d'emails.

## 🔧 Options de Configuration

### Option 1 : Gmail (Recommandé pour les tests)

Modifiez votre fichier `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre.email@gmail.com
MAIL_PASSWORD=votre_mot_de_passe_application
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre.email@gmail.com
MAIL_FROM_NAME="Mon Blog Laravel"
```

**Important pour Gmail :**
1. Activez la validation en 2 étapes sur votre compte Google
2. Générez un "mot de passe d'application" : https://myaccount.google.com/apppasswords
3. Utilisez ce mot de passe d'application dans `MAIL_PASSWORD`

### Option 2 : MailHog (Pour développement local)

1. **Téléchargez MailHog** : https://github.com/mailhog/MailHog/releases
2. **Lancez MailHog** : `mailhog.exe` (Windows)
3. **Modifiez `.env`** :

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@monblog.local
MAIL_FROM_NAME="Mon Blog Laravel"
```

4. **Interface web** : http://127.0.0.1:8025

### Option 3 : Mailtrap (Service de test)

1. **Créez un compte** : https://mailtrap.io
2. **Récupérez les paramètres SMTP**
3. **Modifiez `.env`** :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username_mailtrap
MAIL_PASSWORD=votre_password_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=test@monblog.local
MAIL_FROM_NAME="Mon Blog Laravel"
```

## 🚀 Test du Système

### 1. Configuration terminée
Après avoir configuré l'email, testez :

```bash
php artisan config:clear
php artisan serve
```

### 2. Test de réinitialisation
1. Allez sur : http://127.0.0.1:8000/login
2. Cliquez sur "Mot de passe oublié ?"
3. Saisissez un email existant
4. Vérifiez la réception de l'email

### 3. Fonctionnement sécurisé
- ✅ Email avec lien unique et sécurisé
- ✅ Token valide 1 heure seulement
- ✅ Token à usage unique
- ✅ Email de confirmation après changement
- ✅ Gestion d'erreurs robuste

## 🛠️ Mode Développement

Si l'envoi d'email échoue en mode local (`APP_ENV=local`), le système affichera automatiquement le lien de réinitialisation sur la page web pour faciliter les tests.

## 📧 Templates d'Email

Les emails utilisent des templates HTML professionnels :
- `resources/views/emails/password-reset.blade.php` - Email de réinitialisation
- `resources/views/emails/password-changed.blade.php` - Confirmation de changement

## 🔐 Sécurité Renforcée

Le nouveau système inclut :

1. **Tokens cryptés** dans la base de données
2. **Expiration automatique** après 1 heure
3. **Usage unique** des liens
4. **Validation stricte** des emails
5. **Notifications de sécurité** en cas de changement
6. **Protection contre la réutilisation** des tokens

## ⚡ Commandes Utiles

```bash
# Nettoyer le cache après changement de config
php artisan config:clear

# Tester l'envoi d'email (avec Tinker)
php artisan tinker
Mail::to('test@example.com')->send(new App\Mail\PasswordResetMail(App\Models\User::first(), 'test-token'));

# Voir les logs d'email (mode log)
tail -f storage/logs/laravel.log
```

## 🎯 Recommandation

Pour un déploiement en production, utilisez un service d'email professionnel comme :
- SendGrid
- Mailgun  
- Amazon SES
- Postmark

Ces services offrent une meilleure délivrabilité et des statistiques détaillées.