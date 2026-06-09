# Instructions pour XAMPP/phpMyAdmin

Si les scripts automatiques ne fonctionnent pas, vous pouvez créer les tables manuellement via phpMyAdmin.

## Étape 1 : Accéder à phpMyAdmin

1. Démarrez XAMPP
2. Cliquez sur "Admin" à côté de MySQL
3. Ou allez sur http://localhost/phpmyadmin

## Étape 2 : Sélectionner la base de données

1. Cliquez sur "blog_social" dans la liste à gauche
2. Si elle n'existe pas, créez-la :
   - Cliquez sur "Nouvelle base de données"
   - Nom : `blog_social`
   - Interclassement : `utf8mb4_unicode_ci`

## Étape 3 : Créer la table messages

Cliquez sur l'onglet "SQL" et exécutez cette requête :

```sql
CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  KEY `messages_sender_id_receiver_id_index` (`sender_id`,`receiver_id`),
  KEY `messages_receiver_id_is_read_index` (`receiver_id`,`is_read`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Étape 4 : Créer la table password_reset_tokens

```sql
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Étape 5 : Créer l'utilisateur admin

```sql
INSERT IGNORE INTO `users` (`name`, `email`, `email_verified_at`, `password`, `is_admin`, `created_at`, `updated_at`) 
VALUES (
    'Administrateur', 
    'admin@blog.com', 
    NOW(),
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    1,
    NOW(),
    NOW()
);
```

## Étape 6 : Vérifier

Exécutez cette requête pour vérifier que tout fonctionne :

```sql
SELECT 'Tables créées' as status;
SHOW TABLES;
SELECT email, name, is_admin FROM users WHERE email = 'admin@blog.com';
```

## Étape 7 : Démarrer le blog

1. Ouvrez un terminal dans le dossier du projet
2. Exécutez : `php artisan serve`
3. Accédez à : http://127.0.0.1:8000
4. Connectez-vous avec : admin@blog.com / password

## Résolution de problèmes

### Erreur de clé étrangère
Si vous avez des erreurs de clé étrangère, assurez-vous que la table `users` existe d'abord.

### Mot de passe admin ne fonctionne pas
Le mot de passe haché dans l'exemple correspond à "password". Si cela ne fonctionne pas, utilisez :

```sql
UPDATE users SET password = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE email = 'admin@blog.com';
```