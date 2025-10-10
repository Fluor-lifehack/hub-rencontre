#!/bin/bash

# Script pour générer la documentation API avec Scribe
# Usage: ./scripts/generate-docs.sh

echo "🚀 Génération de la documentation API Rencontre Hub..."

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

# Générer la documentation
echo "📝 Génération de la documentation avec Scribe..."
ddev exec php artisan scribe:generate

if [ $? -eq 0 ]; then
    echo "✅ Documentation générée avec succès!"
    echo ""
    echo "📚 Accès à la documentation:"
    echo "   - HTML: https://rencontre-hub.ddev.site/docs"
    echo "   - Postman: https://rencontre-hub.ddev.site/docs.postman"
    echo "   - OpenAPI: https://rencontre-hub.ddev.site/docs.openapi"
    echo ""
    echo "📁 Fichiers générés:"
    echo "   - Views: resources/views/scribe/"
    echo "   - Assets: public/vendor/scribe/"
    echo "   - Postman: storage/app/private/scribe/collection.json"
    echo "   - OpenAPI: storage/app/private/scribe/openapi.yaml"
else
    echo "❌ Erreur lors de la génération de la documentation"
    exit 1
fi
