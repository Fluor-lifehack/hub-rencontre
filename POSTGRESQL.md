# Migration vers PostgreSQL - Rencontre Hub

## ✅ Migration terminée

Votre application Rencontre Hub a été migrée avec succès de MariaDB vers PostgreSQL 15.

## 📋 Configuration PostgreSQL

### Base de données
- **Type** : PostgreSQL 15
- **Nom** : `rencontre_hub`
- **Host** : `db` (conteneur DDEV)
- **Port** : `5432`
- **Utilisateur** : `db`
- **Mot de passe** : (vide)

### Configuration Laravel
```php
// config/database.php
'default' => env('DB_CONNECTION', 'pgsql'),

'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'rencontre_hub'),
    'username' => env('DB_USERNAME', 'postgres'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => env('DB_CHARSET', 'utf8'),
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => 'prefer',
],
```

## 🗄️ Données migrées

### Tables créées
- ✅ `users` - Utilisateurs
- ✅ `profiles` - Profils utilisateurs
- ✅ `countries` - Pays (131 enregistrements)
- ✅ `cities` - Villes (270 enregistrements)
- ✅ `photos` - Photos
- ✅ `preferences` - Préférences
- ✅ `conversations` - Conversations
- ✅ `favorites` - Favoris
- ✅ `messages` - Messages
- ✅ `views` - Vues
- ✅ `blocks` - Blocages
- ✅ `reports` - Signalements
- ✅ `plans` - Plans d'abonnement
- ✅ `subscriptions` - Abonnements
- ✅ `transactions` - Transactions
- ✅ `notifications` - Notifications
- ✅ `settings` - Paramètres
- ✅ `activity_logs` - Logs d'activité
- ✅ `user_matches` - Matches
- ✅ `administrators` - Administrateurs

### Seeders exécutés
- ✅ `AdministratorSeeder` - Administrateur par défaut
- ✅ `CountrySeeder` - Pays africains et internationaux
- ✅ `CitySeeder` - Villes principales
- ✅ `PlanSeeder` - Plans d'abonnement
- ✅ `SettingSeeder` - Paramètres par défaut

## 🛠️ Commandes utiles

### Connexion à PostgreSQL
```bash
# Se connecter à la base de données
ddev exec psql rencontre_hub

# Lister les tables
ddev exec psql rencontre_hub -c "\dt"

# Voir la structure d'une table
ddev exec psql rencontre_hub -c "\d users"
```

### Sauvegarde et restauration
```bash
# Sauvegarde automatique
./scripts/backup-postgres.sh

# Restauration depuis une sauvegarde
./scripts/restore-postgres.sh database/backups/rencontre_hub_backup_YYYYMMDD_HHMMSS.sql
```

### Migrations Laravel
```bash
# Statut des migrations
ddev exec php artisan migrate:status

# Exécuter les migrations
ddev exec php artisan migrate

# Réinitialiser la base de données
ddev exec php artisan migrate:fresh --seed

# Rollback des migrations
ddev exec php artisan migrate:rollback
```

## 🔧 Maintenance

### Vérification de la connexion
```bash
# Tester la connexion
ddev exec php artisan tinker --execute="echo 'DB: ' . config('database.default');"

# Compter les enregistrements
ddev exec php artisan tinker --execute="use App\Models\User; echo 'Users: ' . User::count();"
```

### Optimisation PostgreSQL
```bash
# Analyser les tables
ddev exec psql rencontre_hub -c "ANALYZE;"

# Vérifier l'espace disque
ddev exec psql rencontre_hub -c "SELECT pg_size_pretty(pg_database_size('rencontre_hub'));"
```

## 📊 Avantages de PostgreSQL

### Fonctionnalités avancées
- **Types de données riches** : JSON, UUID, Array, etc.
- **Index avancés** : GIN, GiST, BRIN
- **Requêtes complexes** : CTE, Window Functions
- **Contraintes avancées** : Check, Exclusion
- **Extensions** : PostGIS, pg_trgm, etc.

### Performance
- **Optimiseur de requêtes** : Plus sophistiqué que MySQL/MariaDB
- **Concurrence** : MVCC (Multi-Version Concurrency Control)
- **Réplication** : Streaming, Logical, etc.
- **Partitionnement** : Table partitioning natif

### Sécurité
- **Contrôle d'accès** : Rôles et permissions granulaires
- **Chiffrement** : SSL/TLS, chiffrement au niveau colonne
- **Audit** : pgAudit pour l'audit des requêtes

## 🚀 Production

### Configuration recommandée
```bash
# Variables d'environnement production
DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=rencontre_hub_prod
DB_USERNAME=rencontre_hub_user
DB_PASSWORD=secure_password
DB_CHARSET=utf8
```

### Optimisations production
```sql
-- Configuration PostgreSQL recommandée
ALTER SYSTEM SET shared_buffers = '256MB';
ALTER SYSTEM SET effective_cache_size = '1GB';
ALTER SYSTEM SET maintenance_work_mem = '64MB';
ALTER SYSTEM SET checkpoint_completion_target = 0.9;
ALTER SYSTEM SET wal_buffers = '16MB';
ALTER SYSTEM SET default_statistics_target = 100;
```

## 🔍 Monitoring

### Requêtes utiles
```sql
-- Taille de la base de données
SELECT pg_size_pretty(pg_database_size('rencontre_hub'));

-- Tables les plus volumineuses
SELECT 
    schemaname,
    tablename,
    pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename)) as size
FROM pg_tables 
WHERE schemaname = 'public'
ORDER BY pg_total_relation_size(schemaname||'.'||tablename) DESC;

-- Requêtes lentes
SELECT query, mean_time, calls 
FROM pg_stat_statements 
ORDER BY mean_time DESC 
LIMIT 10;
```

## 🆘 Dépannage

### Problèmes courants

1. **Erreur de connexion**
   ```bash
   # Vérifier que DDEV est démarré
   ddev status
   
   # Redémarrer les services
   ddev restart
   ```

2. **Permissions insuffisantes**
   ```sql
   -- Accorder les permissions
   GRANT ALL PRIVILEGES ON DATABASE rencontre_hub TO db;
   GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO db;
   ```

3. **Problèmes de migration**
   ```bash
   # Vérifier le statut
   ddev exec php artisan migrate:status
   
   # Forcer la migration
   ddev exec php artisan migrate --force
   ```

### Logs utiles
```bash
# Logs PostgreSQL
ddev logs db

# Logs Laravel
ddev exec tail -f storage/logs/laravel.log
```

## 📚 Documentation

- [PostgreSQL Documentation](https://www.postgresql.org/docs/)
- [Laravel PostgreSQL](https://laravel.com/docs/database#postgresql)
- [DDEV PostgreSQL](https://ddev.readthedocs.io/en/stable/users/database-types/)

---

🎉 **Votre application Rencontre Hub fonctionne maintenant avec PostgreSQL !**
