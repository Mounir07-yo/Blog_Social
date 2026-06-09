-- Créer l'utilisateur admin s'il n'existe pas
INSERT IGNORE INTO `users` (`name`, `email`, `email_verified_at`, `password`, `is_admin`, `created_at`, `updated_at`) 
VALUES (
    'Administrateur', 
    'admin@blog.com', 
    NOW(),
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- password = 'password'
    1,
    NOW(),
    NOW()
);

-- Vérifier que la table est créée
SELECT 'Admin user created/verified' as status;
SELECT email, name, is_admin FROM users WHERE email = 'admin@blog.com';