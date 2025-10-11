<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'user_one' => $this->whenLoaded('userOne', function () {
                return $this->userOne->uuid;
            }),
            'user_two' => $this->whenLoaded('userTwo', function () {
                return $this->userTwo->uuid;
            }),
            'last_message_at' => $this->last_message_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'user_one_profile' => new UserResource($this->whenLoaded('userOne')),
            'user_two_profile' => new UserResource($this->whenLoaded('userTwo')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'last_message' => new MessageResource($this->whenLoaded('lastMessage')),

            // Compteurs
            'messages_count' => $this->when(isset($this->messages_count), $this->messages_count),
            'unread_messages_count' => $this->when(isset($this->unread_messages_count), $this->unread_messages_count),

            // Données calculées
            'last_activity' => $this->when($this->last_message_at, function () {
                return $this->last_message_at->diffForHumans();
            }),
            'is_active' => $this->when($this->last_message_at, function () {
                return $this->last_message_at->isAfter(now()->subDays(7));
            }),
        ];
    }
}
