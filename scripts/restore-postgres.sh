#!/bin/bash

# Script de restauration PostgreSQL pour Rencontre Hub
echo "🔄 Restauration de la base de données PostgreSQL..."

# Vérifier qu'un fichier de sauvegarde est fourni
if [ $# -eq 0 ]; then
    echo "❌ Usage: $0 <fichier_de_sauvegarde.sql>"
    echo "📁 Sauvegardes disponibles :"
    ls -la database/backups/rencontre_hub_backup_*.sql 2>/dev/null || echo "   Aucune sauvegarde trouvée"
    exit 1
fi

BACKUP_FILE="$1"

# Vérifier que le fichier existe
if [ ! -f "$BACKUP_FILE" ]; then
    echo "❌ Fichier de sauvegarde non trouvé : $BACKUP_FILE"
    exit 1
fi

echo "📦 Restauration depuis : $BACKUP_FILE"

# Confirmer avant de continuer
read -p "⚠️  Cette opération va écraser la base de données actuelle. Continuer ? (y/N) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Restauration annulée"
    exit 1
fi

# Arrêter les services si nécessaire
echo "🛑 Arrêt des services..."
ddev stop

# Redémarrer avec PostgreSQL
echo "🚀 Redémarrage des services..."
ddev start

# Restaurer la base de données
echo "📥 Import de la base de données..."
ddev import-db --src="$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "✅ Restauration réussie !"
    echo "🌐 Application disponible sur : https://rencontre-hub.ddev.site"
else
    echo "❌ Erreur lors de la restauration"
    exit 1
fi
