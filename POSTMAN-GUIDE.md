# 🚀 Guide Postman - Rencontre Hub API

## 📋 Vue d'ensemble

Cette collection Postman contient toutes les routes de l'API Rencontre Hub, optimisée pour les tests et le développement.

## 🔧 Configuration

### 1. Importer la collection et l'environnement

1. **Collection** : `Rencontre-Hub-API.postman_collection.json`
2. **Environnement** : `Rencontre-Hub-Environment.postman_environment.json`

### 2. Variables d'environnement

| Variable | Description | Valeur par défaut |
|----------|-------------|-------------------|
| `baseUrl` | URL de base de l'API | `http://localhost:8000` |
| `token` | Token d'authentification | (vide) |
| `userId` | ID d'un utilisateur | (vide) |
| `profileId` | ID d'un profil | (vide) |
| `matchId` | ID d'une correspondance | (vide) |
| `photoId` | ID d'une photo | (vide) |
| `countryId` | ID d'un pays | `dc23c65b-43c7-43e6-be6f-e5aaa6c64421` |
| `planId` | ID d'un plan | (vide) |

## 🔐 Authentification

### Connexion automatique
1. Exécutez la requête **"Connexion"** dans le dossier **"🔐 Authentification"**
2. Le token sera automatiquement extrait et défini dans la variable `token`
3. Toutes les requêtes suivantes utiliseront automatiquement ce token

### Connexion manuelle
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

## 🎯 Utilisation des routes

### 🔐 Authentification
- **POST** `/api/v1/auth/login` - Connexion
- **POST** `/api/v1/auth/register` - Inscription
- **POST** `/api/v1/auth/logout` - Déconnexion
- **GET** `/api/v1/auth/me` - Profil utilisateur

### 👤 Utilisateurs
- **GET** `/api/v1/users` - Liste des utilisateurs
- **POST** `/api/v1/users` - Créer un utilisateur
- **GET** `/api/v1/users/{id}` - Détails d'un utilisateur
- **PUT** `/api/v1/users/{id}` - Modifier un utilisateur
- **🗑️ DELETE** `/api/v1/users/me` - **Supprimer son propre compte**

### 👤 Profils
- **GET** `/api/v1/profiles` - Liste des profils
- **POST** `/api/v1/profiles` - Créer un profil
- **GET** `/api/v1/profiles/{id}` - Détails d'un profil
- **PUT** `/api/v1/profiles/{id}` - Modifier un profil
- **🗑️ DELETE** `/api/v1/profiles/me` - **Supprimer son propre profil**

### 💕 Correspondances
- **GET** `/api/v1/matches` - Liste des correspondances
- **POST** `/api/v1/matches` - Créer une correspondance
- **GET** `/api/v1/matches/{id}` - Détails d'une correspondance
- **PUT** `/api/v1/matches/{id}` - Modifier une correspondance
- **DELETE** `/api/v1/matches/{id}` - Supprimer une correspondance

### 📸 Photos
- **GET** `/api/v1/photos` - Liste des photos
- **POST** `/api/v1/photos` - Uploader une photo
- **GET** `/api/v1/photos/{id}` - Détails d'une photo
- **PUT** `/api/v1/photos/{id}` - Modifier une photo
- **DELETE** `/api/v1/photos/{id}` - Supprimer une photo

### 🌍 Pays (Lecture seule)
- **GET** `/api/v1/countries` - Liste des pays
- **GET** `/api/v1/countries/{id}` - Détails d'un pays

### 💎 Plans (Lecture seule)
- **GET** `/api/v1/plans` - Liste des plans
- **GET** `/api/v1/plans/{id}` - Détails d'un plan

## 🔒 Sécurité - Nouvelles fonctionnalités

### ⚠️ Suppression sécurisée

**IMPORTANT** : Les routes de suppression ont été modifiées pour garantir la sécurité :

#### ✅ **Nouvelles routes sécurisées :**
- `DELETE /api/v1/users/me` - Supprimer **son propre** compte
- `DELETE /api/v1/profiles/me` - Supprimer **son propre** profil

#### ❌ **Anciennes routes supprimées :**
- ~~`DELETE /api/v1/users/{id}`~~ - **Plus accessible**
- ~~`DELETE /api/v1/profiles/{id}`~~ - **Plus accessible**

### 🛡️ Avantages de la sécurité

1. **Impossible de supprimer le compte d'autrui**
2. **Authentification obligatoire**
3. **Vérification automatique de la propriété**
4. **Routes intuitives avec `/me`**

## 📊 Codes de réponse

| Code | Description |
|------|-------------|
| `200` | Succès |
| `201` | Créé avec succès |
| `400` | Erreur de validation |
| `401` | Non authentifié |
| `403` | Accès refusé |
| `404` | Ressource non trouvée |
| `422` | Erreur de validation |
| `500` | Erreur serveur |

## 🧪 Tests recommandés

### 1. Test de connexion
```bash
# 1. Connexion
POST /api/v1/auth/login
# 2. Vérifier le profil
GET /api/v1/auth/me
```

### 2. Test de suppression sécurisée
```bash
# 1. Se connecter avec un utilisateur
POST /api/v1/auth/login
# 2. Supprimer son propre compte
DELETE /api/v1/users/me
# 3. Vérifier que l'utilisateur est supprimé
GET /api/v1/auth/me # → 401 Unauthorized
```

### 3. Test de sécurité
```bash
# 1. Essayer d'accéder à l'ancienne route
DELETE /api/v1/users/some-uuid # → 404 Not Found
# 2. Essayer sans authentification
DELETE /api/v1/users/me # → 401 Unauthorized
```

## 🔧 Scripts automatiques

### Extraction automatique du token
La collection contient un script qui extrait automatiquement le token de la réponse de connexion :

```javascript
// Auto-extract token from login response
if (pm.response && pm.response.json && pm.response.json.data && pm.response.json.data.token) {
    pm.collectionVariables.set('token', pm.response.json.data.token);
    console.log('Token automatiquement extrait et défini');
}
```

## 📝 Exemples de requêtes

### Créer un profil
```json
{
    "bio": "Passionné de voyage et de cuisine",
    "gender": "male",
    "age": 28,
    "country_id": "dc23c65b-43c7-43e6-be6f-e5aaa6c64421",
    "city_id": "50",
    "height": 175,
    "hobbies": ["Voyage", "Cuisine", "Sport"]
}
```

### Créer une correspondance
```json
{
    "matched_user_id": "46b67f53-eeaf-406e-bc87-af4f4e4bea0f",
    "compatibility_score": 85
}
```

## 🚨 Points d'attention

1. **UUIDs** : Tous les IDs utilisent des UUIDs (format : `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx`)
2. **Authentification** : La plupart des routes nécessitent un token Bearer
3. **Suppression** : Seule la suppression de son propre compte/profil est autorisée
4. **Pagination** : Utilisez `per_page` pour limiter les résultats
5. **Filtres** : Les profils supportent des filtres (`gender`, `age`, etc.)

## 📞 Support

Pour toute question ou problème :
- Vérifiez que le serveur Laravel est démarré : `php artisan serve`
- Consultez les logs : `tail -f storage/logs/laravel.log`
- Testez l'API directement : `http://localhost:8000/docs`

---

**🎉 Bonne utilisation de l'API Rencontre Hub !**
