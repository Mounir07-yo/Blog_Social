# Guide : Fonctionnalité "Mot de passe oublié"

## Fonctionnement

### 1. Option "Se souvenir de moi"
- **Fonction** : Permet de rester connecté même après fermeture du navigateur
- **Durée** : Maximum 2 semaines
- **Sécurité** : Crée un cookie sécurisé pour la reconnexion automatique
- **Usage** : Cochez cette option sur vos appareils personnels seulement

### 2. Réinitialisation de mot de passe

#### Étape 1 : Demande de réinitialisation
- Accédez à la page de connexion
- Cliquez sur "Mot de passe oublié ?"
- Saisissez votre adresse email
- Cliquez sur "Envoyer le lien de réinitialisation"

#### Étape 2 : Utilisation du lien
- Un lien de réinitialisation sera généré
- Le système vous redirigera automatiquement vers le formulaire
- **Note** : En production, ce lien serait envoyé par email

#### Étape 3 : Nouveau mot de passe
- Saisissez votre nouveau mot de passe (minimum 8 caractères)
- Confirmez le mot de passe
- Cliquez sur "Réinitialiser le mot de passe"

## Sécurité

### Tokens de réinitialisation
- **Durée de vie** : 1 heure
- **Usage unique** : Le token est supprimé après utilisation
- **Chiffrement** : Tokens stockés de manière sécurisée

### Recommandations mot de passe
- Minimum 8 caractères
- Mélange lettres, chiffres, caractères spéciaux
- Éviter les informations personnelles
- Utiliser un mot de passe unique

## Configuration email (pour production)

Pour activer l'envoi d'emails en production, modifiez le fichier `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Mon Blog Laravel"
```

## Test de la fonctionnalité

1. Créez un compte utilisateur
2. Déconnectez-vous
3. Cliquez sur "Mot de passe oublié"
4. Suivez les étapes de réinitialisation
5. Connectez-vous avec le nouveau mot de passe

## Utilisateurs de test

- **Admin** : admin@blog.com / password
- Créez d'autres comptes pour tester les fonctionnalités

## Dépannage

### Problème : "Token invalide"
- Le token a peut-être expiré (>1h)
- Refaites une nouvelle demande de réinitialisation

### Problème : "Email introuvable"
- Vérifiez l'orthographe de l'email
- Assurez-vous que le compte existe

### Problème : Mot de passe refusé
- Vérifiez que le mot de passe fait au moins 8 caractères
- Assurez-vous que la confirmation correspond