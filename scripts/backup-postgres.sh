#!/bin/bash

# Script de sauvegarde PostgreSQL pour Rencontre Hub
echo "🗄️ Sauvegarde de la base de données PostgreSQL..."

# Configuration
BACKUP_DIR="database/backups"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="rencontre_hub_backup_${TIMESTAMP}.sql"

# Créer le dossier de sauvegarde s'il n'existe pas
mkdir -p "$BACKUP_DIR"

# Exporter la base de données
echo "📦 Export de la base de données..."
ddev export-db --file="$BACKUP_DIR/$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "✅ Sauvegarde réussie : $BACKUP_DIR/$BACKUP_FILE"

    # Afficher la taille du fichier
    if [ -f "$BACKUP_DIR/$BACKUP_FILE" ]; then
        FILE_SIZE=$(du -h "$BACKUP_DIR/$BACKUP_FILE" | cut -f1)
        echo "📊 Taille du fichier : $FILE_SIZE"
    fi

    # Garder seulement les 5 dernières sauvegardes
    echo "🧹 Nettoyage des anciennes sauvegardes..."
    cd "$BACKUP_DIR"
    ls -t rencontre_hub_backup_*.sql | tail -n +6 | xargs -r rm
    cd - > /dev/null

    echo "🎉 Sauvegarde terminée avec succès !"
else
    echo "❌ Erreur lors de la sauvegarde"
    exit 1
fi
