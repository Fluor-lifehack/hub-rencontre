<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal privé pour les conversations
Broadcast::channel('conversation.{id}', function ($user, $id) {
    // Vérifier si l'utilisateur fait partie de la conversation
    return $user->conversations()->where('conversations.id', $id)->exists();
});

// Canal privé pour les utilisateurs
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal public pour les notifications générales
Broadcast::channel('notifications', function () {
    return true;
});
