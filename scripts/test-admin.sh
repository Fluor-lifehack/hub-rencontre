#!/bin/bash

# Script pour tester l'accès à l'administration Filament
# Usage: ./scripts/test-admin.sh

echo "🚀 Test de l'administration Rencontre Hub..."

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

echo "📊 Vérification des données de test..."

# Vérifier les administrateurs
echo "👥 Administrateurs:"
ddev exec php artisan tinker --execute="echo 'Super Admin: ' . (App\Models\Administrator::where('email', 'admin@rencontre-hub.com')->exists() ? 'Existe' : 'N\'existe pas') . PHP_EOL;"

echo "🌍 Données géographiques:"
ddev exec php artisan tinker --execute="echo 'Pays: ' . App\Models\Country::count() . PHP_EOL; echo 'Villes: ' . App\Models\City::count() . PHP_EOL;"

echo "💳 Plans d'abonnement:"
ddev exec php artisan tinker --execute="echo 'Plans: ' . App\Models\Plan::count() . PHP_EOL;"

echo ""
echo "🔗 Accès à l'administration:"
echo "   URL: https://rencontre-hub.ddev.site/admin"
echo ""
echo "📝 Identifiants de connexion:"
echo "   Super Admin:"
echo "     Email: admin@rencontre-hub.com"
echo "     Mot de passe: password"
echo ""
echo "   Moderator:"
echo "     Email: moderator@rencontre-hub.com"
echo "     Mot de passe: password"
echo ""
echo "✅ Administration prête!"
