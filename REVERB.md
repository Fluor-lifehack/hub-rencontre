# Laravel Reverb - WebSockets pour Rencontre Hub

## 🚀 Installation terminée

Laravel Reverb a été installé avec succès dans votre application Rencontre Hub. Voici comment l'utiliser :

## 📋 Configuration

### Variables d'environnement

Les variables suivantes ont été configurées dans le script de démarrage :

```bash
REVERB_APP_ID=rencontre-hub
REVERB_APP_KEY=rencontre-hub-key
REVERB_APP_SECRET=rencontre-hub-secret
REVERB_HOST=rencontre-hub.ddev.site
REVERB_PORT=8080
REVERB_SCHEME=http
REVERB_SERVER_HOST=0.0.0.0
REVERB_SERVER_PORT=8080
BROADCAST_CONNECTION=reverb
```

## 🔧 Démarrage du serveur

### Méthode 1 : Script automatique
```bash
./scripts/start-reverb.sh
```

### Méthode 2 : Commande directe
```bash
ddev exec php artisan reverb:start
```

## 🧪 Test des WebSockets

### Page de test
Visitez : https://rencontre-hub.ddev.site/websocket-test

Cette page vous permet de :
- Tester la connexion WebSocket
- Voir les messages en temps réel
- Simuler des événements

### API de test
```bash
# Envoyer un événement de test
curl -X POST https://rencontre-hub.ddev.site/test/event \
  -H "Content-Type: application/json" \
  -d '{"message": "Hello WebSocket!"}'

# Simuler un match
curl -X POST https://rencontre-hub.ddev.site/test/match \
  -H "Content-Type: application/json" \
  -d '{"user1_id": 1, "user2_id": 2}'

# Simuler un message
curl -X POST https://rencontre-hub.ddev.site/test/message \
  -H "Content-Type: application/json" \
  -d '{"conversation_id": 1, "sender_id": 1, "content": "Hello!"}'
```

## 📡 Canaux disponibles

### Canaux privés
- `user.{id}` - Canal privé pour un utilisateur spécifique
- `conversation.{id}` - Canal privé pour une conversation
- `App.Models.User.{id}` - Canal Laravel standard

### Canaux publics
- `notifications` - Canal public pour les notifications générales

## 🎯 Événements disponibles

### MessageSent
```php
use App\Events\MessageSent;
broadcast(new MessageSent($message));
```

### MatchFound
```php
use App\Events\MatchFound;
broadcast(new MatchFound($match));
```

## 🔐 Authentification

L'authentification des canaux privés est gérée par Laravel via `/broadcasting/auth`.

## 📱 Intégration côté client

### JavaScript (Pusher)
```javascript
const pusher = new Pusher('rencontre-hub-key', {
    cluster: 'mt1',
    host: 'rencontre-hub.ddev.site',
    port: 8080,
    scheme: 'http',
    encrypted: false
});

// S'abonner à un canal
const channel = pusher.subscribe('notifications');

// Écouter un événement
channel.bind('test', function(data) {
    console.log('Événement reçu:', data);
});
```

### Laravel Echo
```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'rencontre-hub-key',
    cluster: 'mt1',
    host: 'rencontre-hub.ddev.site',
    port: 8080,
    scheme: 'http',
    encrypted: false,
});

// Écouter un canal privé
Echo.private('user.1')
    .listen('MatchFound', (e) => {
        console.log('Match trouvé:', e);
    });
```

## 🛠️ Développement

### Logs
Les logs du serveur Reverb sont affichés dans la console où vous avez lancé le serveur.

### Debug
Pour activer le mode debug, ajoutez dans votre `.env` :
```bash
LOG_LEVEL=debug
```

## 🚀 Production

### Configuration recommandée
- Utilisez HTTPS en production
- Configurez un reverse proxy (Nginx/Apache)
- Utilisez Redis pour le scaling si nécessaire
- Configurez les variables d'environnement appropriées

### Scaling
Pour activer le scaling avec Redis :
```bash
REVERB_SCALING_ENABLED=true
REVERB_SCALING_CHANNEL=reverb
REDIS_URL=redis://localhost:6379
```

## 📚 Documentation officielle

- [Laravel Reverb Documentation](https://laravel.com/docs/reverb)
- [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
- [Pusher Protocol](https://pusher.com/docs/channels/library_auth_reference/pusher-websockets-protocol/)

## 🆘 Dépannage

### Problèmes courants

1. **Connexion refusée**
   - Vérifiez que le serveur Reverb est démarré
   - Vérifiez les ports et l'host

2. **Authentification échouée**
   - Vérifiez la configuration CSRF
   - Vérifiez les routes d'authentification

3. **Événements non reçus**
   - Vérifiez que l'événement implémente `ShouldBroadcast`
   - Vérifiez les canaux et les autorisations

### Commandes utiles
```bash
# Vérifier la configuration
ddev exec php artisan config:show broadcasting

# Vider le cache
ddev exec php artisan config:clear
ddev exec php artisan route:clear

# Vérifier les routes
ddev exec php artisan route:list | grep broadcast
```

---

🎉 **Votre serveur WebSocket Reverb est maintenant prêt à être utilisé !**
