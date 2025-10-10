<?php

namespace App\Http\Controllers;

use App\Events\MatchFound;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class TestController extends Controller
{
    /**
     * Page de test des WebSockets
     */
    public function index()
    {
        return view('test-websocket');
    }

    /**
     * Envoyer un événement de test
     */
    public function sendTestEvent(Request $request)
    {
        $message = $request->input('message', 'Test message from server');

        Broadcast::event('notifications', 'test', [
            'message' => $message,
            'timestamp' => now()->toISOString(),
            'server' => 'Rencontre Hub'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Événement de test envoyé'
        ]);
    }

    /**
     * Simuler un match trouvé
     */
    public function simulateMatch(Request $request)
    {
        $user1Id = $request->input('user1_id', 1);
        $user2Id = $request->input('user2_id', 2);

        // Créer un match fictif pour le test
        $match = new UserMatch([
            'id' => rand(1000, 9999),
            'user1_id' => $user1Id,
            'user2_id' => $user2Id,
            'created_at' => now()
        ]);

        // Diffuser l'événement
        broadcast(new MatchFound($match));

        return response()->json([
            'success' => true,
            'message' => 'Événement de match simulé',
            'match' => $match
        ]);
    }

    /**
     * Simuler un message envoyé
     */
    public function simulateMessage(Request $request)
    {
        $conversationId = $request->input('conversation_id', 1);
        $senderId = $request->input('sender_id', 1);
        $content = $request->input('content', 'Message de test');

        // Créer un message fictif pour le test
        $message = new Message([
            'id' => rand(1000, 9999),
            'conversation_id' => $conversationId,
            'sender_id' => $senderId,
            'content' => $content,
            'created_at' => now()
        ]);

        // Diffuser l'événement
        broadcast(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => 'Événement de message simulé',
            'message_data' => $message
        ]);
    }
}
