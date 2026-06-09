-- Création de la base de données pour le blog social
CREATE DATABASE IF NOT EXISTS `blog_social` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE `blog_social`;

-- Afficher un message de confirmation
SELECT 'Base de données blog_social créée avec succès !' AS message;