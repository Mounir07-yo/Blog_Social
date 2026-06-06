#!/bin/bash

# 🚀 Script de déploiement rapide pour Blog Social
# Usage: ./quick-deploy.sh

set -e

echo "🚀 === DÉPLOIEMENT BLOG SOCIAL ==="
echo ""

# Couleurs
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Vérifications préliminaires
echo -e "${BLUE}📋 Vérifications préliminaires...${NC}"

if [ ! -f "composer.json" ]; then
    echo -e "${RED}❌ Erreur: composer.json non trouvé${NC}"
    exit 1
fi

if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ Erreur: Ce n'est pas un projet Laravel${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Projet Laravel détecté${NC}"

# Installation des dépendances
echo -e "${BLUE}📦 Installation des dépendances...${NC}"
composer install --no-dev --optimize-autoloader --quiet

# Configuration
echo -e "${BLUE}⚙️ Configuration de l'application...${NC}"

# Copier le fichier de production si pas de .env
if [ ! -f ".env" ]; then
    if [ -f ".env.production" ]; then
        cp .env.production .env
        echo -e "${GREEN}✅ Fichier .env créé depuis .env.production${NC}"
    else
        echo -e "${YELLOW}⚠️  Pas de fichier .env trouvé. Copiez .env.example et configurez-le.${NC}"
    fi
fi

# Génération de la clé d'application
echo -e "${BLUE}🔑 Génération de la clé d'application...${NC}"
php artisan key:generate --force --quiet

# Optimisations Laravel
echo -e "${BLUE}⚡ Optimisation de Laravel...${NC}"
php artisan config:cache --quiet
php artisan route:cache --quiet
php artisan view:cache --quiet

# Base de données
echo -e "${BLUE}🗄️ Configuration de la base de données...${NC}"
php artisan migrate --force --quiet

# Données de test (optionnel)
read -p "Voulez-vous insérer des données de test ? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${BLUE}🌱 Insertion des données de test...${NC}"
    php artisan db:seed --force --quiet
    echo -e "${GREEN}✅ Données de test insérées${NC}"
fi

# Stockage
echo -e "${BLUE}📁 Configuration du stockage...${NC}"
php artisan storage:link --quiet

# Optimisation finale
echo -e "${BLUE}🔧 Optimisation finale...${NC}"
php artisan optimize --quiet

# Permissions (si sur Linux/Mac)
if [[ "$OSTYPE" == "linux-gnu"* ]] || [[ "$OSTYPE" == "darwin"* ]]; then
    echo -e "${BLUE}🔒 Configuration des permissions...${NC}"
    chmod -R 755 storage bootstrap/cache
fi

echo ""
echo -e "${GREEN}🎉 === DÉPLOIEMENT TERMINÉ AVEC SUCCÈS ! ===${NC}"
echo ""
echo -e "${YELLOW}📝 Prochaines étapes :${NC}"
echo "1. 🌐 Configurez votre serveur web (Nginx/Apache)"
echo "2. 🔒 Configurez HTTPS avec Let's Encrypt"
echo "3. 📊 Surveillez les logs dans storage/logs/"
echo "4. 🔄 Configurez les sauvegardes de la base de données"
echo ""
echo -e "${GREEN}🚀 Votre blog social est prêt à être utilisé !${NC}"

# Affichage des informations utiles
if command -v php &> /dev/null; then
    echo ""
    echo -e "${BLUE}ℹ️  Informations système :${NC}"
    echo "PHP Version: $(php -r 'echo PHP_VERSION;')"
    echo "Laravel Version: $(php artisan --version)"
fi

# Test rapide
echo ""
echo -e "${BLUE}🧪 Test rapide de l'application...${NC}"
if php artisan route:list --quiet &> /dev/null; then
    echo -e "${GREEN}✅ Application Laravel fonctionnelle${NC}"
else
    echo -e "${RED}❌ Problème détecté avec l'application${NC}"
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN} 🎊 BLOG SOCIAL DÉPLOYÉ AVEC SUCCÈS ! 🎊${NC}"
echo -e "${GREEN}========================================${NC}"