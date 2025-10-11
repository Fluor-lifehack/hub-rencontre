# 📋 Collection Postman - Rencontre Hub API

## 🚀 Installation

### 1. Importer la collection
1. Ouvrir Postman
2. Cliquer sur "Import"
3. Sélectionner le fichier `Rencontre-Hub-API.postman_collection.json`
4. Cliquer sur "Import"

### 2. Importer l'environnement
1. Dans Postman, aller dans "Environments"
2. Cliquer sur "Import"
3. Sélectionner le fichier `Rencontre-Hub-Environment.postman_environment.json`
4. Cliquer sur "Import"
5. Sélectionner l'environnement "Rencontre Hub - Développement"

## 🔐 Authentification automatique

### Configuration
- L'authentification Bearer Token est configurée automatiquement
- Le token est sauvegardé automatiquement après la connexion
- Utilisez la variable `{{token}}` dans vos requêtes

### Première connexion
1. Exécuter la requête "🔐 Authentification > Connexion"
2. Le token sera automatiquement sauvegardé
3. Toutes les autres requêtes utiliseront ce token

## 📚 Structure de la collection

### 🔐 Authentification
- **Connexion** - POST `/auth/login`
- **Inscription** - POST `/auth/register`
- **Déconnexion** - POST `/auth/logout`
- **Profil utilisateur actuel** - GET `/auth/me`

### 👤 Profils
- **Liste des profils** - GET `/profiles`
- **Profils féminins** - GET `/profiles?gender=female`
- **Profils masculins** - GET `/profiles?gender=male`
- **Filtre par âge** - GET `/profiles?age_min=25&age_max=35`
- **Recherche textuelle** - GET `/profiles?search=voyage`
- **Détails d'un profil** - GET `/profiles/{id}`
- **Créer un profil** - POST `/profiles`
- **Modifier un profil** - PUT `/profiles/{id}`
- **Supprimer un profil** - DELETE `/profiles/{id}`

### 💕 Matches
- **Liste des matches** - GET `/matches`
- **Matches mutuels** - GET `/matches?is_mutual=true`
- **Créer un match** - POST `/matches`
- **Détails d'un match** - GET `/matches/{id}`
- **Mettre à jour un match** - PUT `/matches/{id}`
- **Supprimer un match** - DELETE `/matches/{id}`

### 📸 Photos
- **Liste des photos** - GET `/photos`
- **Photos d'un utilisateur** - GET `/photos?user_id=1`
- **Photo de profil** - GET `/photos?is_profile=true`
- **Détails d'une photo** - GET `/photos/{id}`
- **Supprimer une photo** - DELETE `/photos/{id}`

### 🌍 Pays et Villes
- **Liste des pays** - GET `/countries`
- **Détails d'un pays** - GET `/countries/{id}`

### 💎 Plans
- **Liste des plans** - GET `/plans`
- **Détails d'un plan** - GET `/plans/{id}`

### 👥 Utilisateurs
- **Liste des utilisateurs** - GET `/users`
- **Détails d'un utilisateur** - GET `/users/{id}`
- **Créer un utilisateur** - POST `/users`
- **Modifier un utilisateur** - PUT `/users/{id}`
- **Supprimer un utilisateur** - DELETE `/users/{id}`

### 🧪 Tests
- **Test de connexion automatique** - Teste l'authentification
- **Test des profils avec token** - Teste l'accès aux profils

## 🎯 Comptes de test disponibles

| Email | Mot de passe | Profil |
|-------|-------------|--------|
| `marie.dubois@example.com` | `password` | Femme, 28 ans, Architecte |
| `pierre.martin@example.com` | `password` | Homme, 32 ans, Ingénieur |
| `sophie.laurent@example.com` | `password` | Femme, 25 ans, Artiste |
| `antoine.rousseau@example.com` | `password` | Homme, 29 ans, Chef |
| `camille.petit@example.com` | `password` | Femme, 30 ans, Professeur |

## 🔧 Variables d'environnement

| Variable | Valeur par défaut | Description |
|----------|------------------|-------------|
| `baseUrl` | `http://localhost:8000/api/v1` | URL de base de l'API |
| `token` | (vide) | Token d'authentification |
| `userId` | `1` | ID d'utilisateur pour les tests |
| `profileId` | `1` | ID de profil pour les tests |
| `matchId` | `1` | ID de match pour les tests |
| `photoId` | `1` | ID de photo pour les tests |
| `countryId` | `1` | ID de pays pour les tests |
| `planId` | `1` | ID de plan pour les tests |

## 📊 Filtres disponibles pour les profils

### Paramètres de requête
- `page` - Numéro de page (défaut: 1)
- `per_page` - Nombre d'éléments par page (max: 50, défaut: 15)
- `search` - Recherche par bio ou nom d'utilisateur
- `gender` - Filtrer par genre (`male`, `female`, `other`)
- `age_min` - Âge minimum
- `age_max` - Âge maximum
- `country_id` - ID du pays
- `city_id` - ID de la ville

### Exemples d'URLs
```
GET /profiles?gender=female&age_min=25&age_max=35&per_page=20
GET /profiles?search=voyage&city_id=1
GET /profiles?country_id=1&gender=male
```

## 🧪 Tests automatisés

### Tests de connexion
- Vérifie que la connexion retourne un statut 200
- Vérifie que le token est présent dans la réponse
- Sauvegarde automatiquement le token

### Tests d'accès
- Vérifie que l'accès aux profils est autorisé
- Vérifie que les données sont bien formatées
- Vérifie la structure de la réponse

## 🚨 Codes d'erreur

| Code | Description |
|------|-------------|
| `200` | Succès |
| `201` | Créé avec succès |
| `400` | Requête invalide |
| `401` | Non authentifié |
| `403` | Non autorisé |
| `404` | Ressource non trouvée |
| `422` | Erreur de validation |
| `500` | Erreur serveur |

## 💡 Conseils d'utilisation

### 1. Ordre d'exécution recommandé
1. **Connexion** - Pour obtenir le token
2. **Profil utilisateur actuel** - Vérifier l'authentification
3. **Liste des profils** - Explorer les données disponibles
4. **Tests spécifiques** - Selon vos besoins

### 2. Gestion des tokens
- Le token expire après un certain temps
- Réexécutez la connexion si vous obtenez une erreur 401
- Le token est automatiquement mis à jour

### 3. Tests de performance
- Utilisez `per_page` pour limiter les résultats
- Testez avec différents filtres
- Vérifiez les temps de réponse

## 🔄 Mise à jour

Pour mettre à jour la collection :
1. Régénérez la documentation avec `php artisan scribe:generate`
2. Importez la nouvelle collection générée
3. Ou modifiez manuellement les requêtes selon vos besoins

## 📞 Support

En cas de problème :
1. Vérifiez que le serveur Laravel est démarré (`php artisan serve`)
2. Vérifiez l'authentification (token valide)
3. Consultez les logs Laravel (`storage/logs/laravel.log`)
4. Vérifiez la documentation API (`http://localhost:8000/docs`)

---

**Collection créée le :** 11 octobre 2025  
**Version API :** 1.0.0  
**Environnement :** Développement local
