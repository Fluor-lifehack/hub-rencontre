# Rencontre Hub

Rencontre Hub est une application de rencontres africaine qui vous connecte avec des personnes partageant vos intérêts.

## Fonctionnalités

- **Profils détaillés** : Créez un profil complet avec photos, bio et préférences
- **Géolocalisation** : Trouvez des personnes près de chez vous
- **Chat en temps réel** : Communiquez instantanément avec vos matches
- **Système de likes** : Exprimez votre intérêt facilement
- **Abonnements premium** : Accédez à des fonctionnalités avancées
- **WebSockets** : Notifications en temps réel avec Laravel Reverb

## Technologies utilisées

- **Backend** : Laravel 11 avec PHP 8.3
- **Base de données** : PostgreSQL 15
- **Interface d'administration** : Filament 3
- **Documentation API** : Scribe
- **WebSockets** : Laravel Reverb
- **Authentification** : Laravel Sanctum
- **Développement local** : DDEV

## Installation

### Prérequis

- Docker et DDEV installés
- PHP 8.3+
- Composer

### Étapes d'installation

1. **Cloner le projet**

   ```bash
   git clone <repository-url>
   cd rencontre-hub
   ```

2. **Configurer DDEV**

   ```bash
   ddev config --database=postgresql:15
   ddev start
   ```

3. **Installer les dépendances**

   ```bash
   ddev composer install
   ```

4. **Configurer l'environnement**

   ```bash
   ddev exec cp .env.example .env
   ddev exec php artisan key:generate
   ```

5. **Migrer et peupler la base de données**

   ```bash
   ddev exec php artisan migrate:fresh --seed
   ```

6. **Créer un administrateur**

   ```bash
   ddev exec php artisan db:seed --class=AdministratorSeeder
   ```

## Accès

- **Interface d'administration** : [https://rencontre-hub.ddev.site/admin](https://rencontre-hub.ddev.site/admin)
- **Documentation API** : [https://rencontre-hub.ddev.site/docs](https://rencontre-hub.ddev.site/docs)
- **Test WebSocket** : [https://rencontre-hub.ddev.site/websocket-test](https://rencontre-hub.ddev.site/websocket-test)

## Configuration

### Base de données

L'application utilise PostgreSQL avec les paramètres suivants :

- **Base de données** : `rencontre_hub`
- **Utilisateur** : `db`
- **Mot de passe** : (vide)

### Devise

L'application utilise le Franc CFA (XOF) comme devise principale.

### WebSockets

Laravel Reverb est configuré pour les notifications en temps réel :

- **Port** : 8080
- **Host** : 127.0.0.1

## Scripts utiles

- **Sauvegarde PostgreSQL** : `./scripts/backup-postgres.sh`
- **Restauration PostgreSQL** : `./scripts/restore-postgres.sh <fichier.sql>`
- **Démarrer Reverb** : `./scripts/start-reverb.sh`

## API

L'API REST est documentée avec Scribe et accessible à l'adresse `/docs`. Elle inclut :

- **Authentification** : Inscription/connexion par téléphone ou email
- **Profils** : Gestion des profils utilisateurs
- **Photos** : Upload et gestion des photos
- **Matches** : Système de correspondances
- **Messages** : Chat en temps réel
- **Abonnements** : Gestion des plans premium

## Développement

### Structure du projet

```text
app/
├── Http/Controllers/Api/     # Contrôleurs API
├── Models/                   # Modèles Eloquent
├── Filament/Resources/      # Ressources Filament
└── Events/                  # Événements WebSocket

database/
├── migrations/              # Migrations de base de données
├── seeders/                 # Seeders pour les données initiales
└── factories/               # Factories pour les tests

config/
├── database.php             # Configuration PostgreSQL
├── scribe.php               # Configuration documentation API
└── reverb.php               # Configuration WebSockets
```

### Tests

```bash
ddev exec php artisan test
```

## Licence

Ce projet est sous licence MIT.
