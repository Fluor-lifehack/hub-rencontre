# 🌟 Seeders Rencontre Hub

Ce document explique comment utiliser les différents seeders pour créer des données de test réalistes pour votre application de rencontres.

## 📋 Vue d'ensemble

Nous avons créé plusieurs seeders pour générer des données de test complètes :

- **UserSeeder** : Crée 200 utilisateurs avec profils complets
- **MassiveUserSeeder** : Crée 1000 utilisateurs supplémentaires
- **RealisticUserSeeder** : Crée des utilisateurs avec des profils très détaillés et réalistes
- **SeedUsersCommand** : Commande Artisan pour faciliter l'exécution

## 🚀 Utilisation rapide

### Option 1 : Commande Artisan (Recommandée)

```bash
# Créer 1000 utilisateurs avec profils standards
php artisan seed:users --count=1000

# Créer des utilisateurs réalistes avec profils détaillés
php artisan seed:users --realistic

# Créer 500 utilisateurs
php artisan seed:users --count=500
```

### Option 2 : Script bash

```bash
# Exécuter le script complet
./scripts/seed-users.sh
```

### Option 3 : Seeders individuels

```bash
# Nettoyer et recréer la base
php artisan migrate:fresh

# Exécuter les seeders de base
php artisan db:seed --class=DatabaseSeeder

# Ajouter des utilisateurs
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=MassiveUserSeeder
php artisan db:seed --class=RealisticUserSeeder
```

## 📊 Données générées

### Utilisateurs et Profils

- **200-1200 utilisateurs** selon le seeder choisi
- **Profils complets** avec bio, âge, taille, centres d'intérêt
- **Noms français réalistes** selon le genre
- **Numéros de téléphone français** valides
- **Emails uniques** pour chaque utilisateur

### Géolocalisation

- **8 pays** : France, Belgique, Suisse, Canada, Espagne, Italie, Allemagne, Royaume-Uni
- **40+ villes** principalement françaises
- **Répartition réaliste** par région

### Photos

- **2-6 photos par utilisateur**
- **Photo de profil** automatiquement définie
- **Chemins réalistes** pour les images

### Matches et Conversations

- **150-200 matches** selon le nombre d'utilisateurs
- **50% de matches mutuels** pour créer des conversations
- **Conversations réalistes** avec 10-50 messages
- **Messages variés** : salutations, questions, suggestions de rendez-vous

## 🎯 Profils réalistes créés

### Profils féminins

- **Amélie Rousseau** - Architecte d'intérieur (Paris)
- **Camille Dubois** - Chef pâtissière (Lyon)
- **Léa Martin** - Médecin généraliste (Marseille)
- **Sophie Laurent** - Ingénieure aérospatiale (Toulouse)
- **Emma Petit** - Professeure de français (Nice)
- **Julie Moreau** - Designer graphique (Nantes)
- **Manon Blanc** - Juriste européenne (Strasbourg)
- **Chloé Simon** - Sommelière (Bordeaux)
- **Aurélie Durand** - Commerçante (Lille)
- **Fanny Roux** - Psychologue (Paris)

### Profils masculins

- **Pierre Martin** - Développeur full-stack (Paris)
- **Antoine Dubois** - Chef cuisinier (Lyon)
- **Lucas Rousseau** - Photographe de mariage (Marseille)
- **Thomas Laurent** - Ingénieur aérospatial (Toulouse)
- **Nicolas Petit** - Entrepreneur digital (Nice)
- **Julien Moreau** - Architecte (Nantes)
- **Maxime Blanc** - Juriste européen (Strasbourg)
- **Baptiste Simon** - Sommelier (Bordeaux)
- **Quentin Durand** - Commerçant (Lille)
- **Alexandre Roux** - Médecin spécialiste (Paris)

## 🔧 Personnalisation

### Modifier le nombre d'utilisateurs

Dans `UserSeeder.php` :
```php
// Changer le nombre d'utilisateurs
User::factory(500)->create(); // Au lieu de 200
```

### Ajouter de nouveaux centres d'intérêt

Dans `UserFactory.php` :
```php
$hobbies = [
    'Voyage', 'Cuisine', 'Photographie', 'Sport', 'Musique', 'Cinéma', 'Lecture',
    'Danse', 'Peinture', 'Randonnée', 'Natation', 'Tennis', 'Football', 'Basketball',
    'Yoga', 'Pilates', 'Course à pied', 'Vélo', 'Escalade', 'Ski', 'Surf', 'Plongée',
    // Ajouter vos centres d'intérêt ici
    'Nouveau hobby 1', 'Nouveau hobby 2'
];
```

### Modifier les bios

Dans `UserFactory.php`, section `generateBio()` :
```php
$maleBios = [
    "Votre nouveau bio pour les hommes...",
    // Ajouter d'autres bios
];

$femaleBios = [
    "Votre nouveau bio pour les femmes...",
    // Ajouter d'autres bios
];
```

## 📈 Statistiques après seeding

Après avoir exécuté les seeders, vous devriez avoir :

- **1000+ utilisateurs** avec profils complets
- **1000+ profils** détaillés
- **8 pays** et **40+ villes**
- **3000+ photos** d'utilisateurs
- **200+ matches** entre utilisateurs
- **100+ conversations** avec messages
- **2000+ messages** réalistes

## 🧪 Comptes de test

Voici quelques comptes de test que vous pouvez utiliser :

| Email | Mot de passe | Profil |
|-------|-------------|--------|
| marie.dubois@example.com | password | Femme, 28 ans, Paris |
| pierre.martin@example.com | password | Homme, 32 ans, Lyon |
| sophie.laurent@example.com | password | Femme, 25 ans, Marseille |
| antoine.rousseau@example.com | password | Homme, 29 ans, Paris |
| camille.petit@example.com | password | Femme, 30 ans, Lyon |

## 🔍 Vérification des données

Pour vérifier que les données ont été créées correctement :

```bash
# Compter les utilisateurs
php artisan tinker --execute="echo App\Models\User::count();"

# Compter les profils
php artisan tinker --execute="echo App\Models\Profile::count();"

# Voir un profil
php artisan tinker --execute="echo App\Models\Profile::with('user')->first();"
```

## 🎉 Résultat

Avec ces seeders, vous disposez maintenant d'une base de données complète et réaliste pour tester votre application de rencontres. Les utilisateurs ont des profils variés, des centres d'intérêt diversifiés, et des conversations naturelles qui simulent une vraie application de rencontres.

Bon développement ! 🚀
