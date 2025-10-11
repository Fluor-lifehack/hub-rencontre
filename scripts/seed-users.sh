#!/bin/bash

# Script pour exécuter les seeders de Rencontre Hub
# Ce script permet de créer beaucoup d'utilisateurs réalistes pour les tests

echo "🚀 Démarrage des seeders Rencontre Hub..."

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

# Nettoyer la base de données
echo "🧹 Nettoyage de la base de données..."
php artisan migrate:fresh

# Exécuter les seeders de base
echo "📊 Exécution des seeders de base..."
php artisan db:seed --class=DatabaseSeeder

# Exécuter le seeder massif d'utilisateurs
echo "👥 Création de 1000 utilisateurs supplémentaires..."
php artisan db:seed --class=MassiveUserSeeder

# Afficher les statistiques
echo "📈 Statistiques de la base de données:"
echo "=================================="

# Compter les utilisateurs
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();")
echo "👤 Nombre d'utilisateurs: $USER_COUNT"

# Compter les profils
PROFILE_COUNT=$(php artisan tinker --execute="echo App\Models\Profile::count();")
echo "📝 Nombre de profils: $PROFILE_COUNT"

# Compter les pays
COUNTRY_COUNT=$(php artisan tinker --execute="echo App\Models\Country::count();")
echo "🌍 Nombre de pays: $COUNTRY_COUNT"

# Compter les villes
CITY_COUNT=$(php artisan tinker --execute="echo App\Models\City::count();")
echo "🏙️  Nombre de villes: $CITY_COUNT"

# Compter les photos
PHOTO_COUNT=$(php artisan tinker --execute="echo App\Models\Photo::count();")
echo "📸 Nombre de photos: $PHOTO_COUNT"

# Compter les matches
MATCH_COUNT=$(php artisan tinker --execute="echo App\Models\UserMatch::count();")
echo "💕 Nombre de matches: $MATCH_COUNT"

# Compter les conversations
CONVERSATION_COUNT=$(php artisan tinker --execute="echo App\Models\Conversation::count();")
echo "💬 Nombre de conversations: $CONVERSATION_COUNT"

# Compter les messages
MESSAGE_COUNT=$(php artisan tinker --execute="echo App\Models\Message::count();")
echo "📨 Nombre de messages: $MESSAGE_COUNT"

echo ""
echo "✅ Seeders terminés avec succès!"
echo ""
echo "🔗 Vous pouvez maintenant:"
echo "   - Tester l'API avec: php artisan serve"
echo "   - Accéder au frontend sur: http://localhost:3000"
echo "   - Utiliser les comptes de test:"
echo "     * marie.dubois@example.com"
echo "     * pierre.martin@example.com"
echo "     * sophie.laurent@example.com"
echo ""
echo "🎉 Bon développement!"
