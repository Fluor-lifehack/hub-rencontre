#!/bin/bash

# Script pour démarrer le serveur Reverb
echo "🚀 Démarrage du serveur Reverb..."

# Configuration des variables d'environnement pour Reverb
export REVERB_APP_ID=rencontre-hub
export REVERB_APP_KEY=rencontre-hub-key
export REVERB_APP_SECRET=rencontre-hub-secret
export REVERB_HOST=rencontre-hub.ddev.site
export REVERB_PORT=8080
export REVERB_SCHEME=http
export REVERB_SERVER_HOST=0.0.0.0
export REVERB_SERVER_PORT=8080
export BROADCAST_CONNECTION=reverb

# Démarrer le serveur Reverb
echo "📡 Serveur Reverb démarré sur http://rencontre-hub.ddev.site:8080"
echo "🔗 Configuration:"
echo "   - Host: $REVERB_SERVER_HOST"
echo "   - Port: $REVERB_SERVER_PORT"
echo "   - App ID: $REVERB_APP_ID"
echo "   - App Key: $REVERB_APP_KEY"
echo ""
echo "Pour arrêter le serveur, utilisez Ctrl+C"
echo ""

php artisan reverb:start
