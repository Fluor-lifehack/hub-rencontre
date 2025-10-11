<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'conversation_id' => $this->whenLoaded('conversation', function () {
                return $this->conversation->uuid;
            }),
            'sender_id' => $this->whenLoaded('sender', function () {
                return $this->sender->uuid;
            }),
            'content' => $this->content,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'conversation' => new ConversationResource($this->whenLoaded('conversation')),
            'sender' => new UserResource($this->whenLoaded('sender')),

            // Données calculées
            'time_ago' => $this->when($this->created_at, function () {
                return $this->created_at->diffForHumans();
            }),
            'is_recent' => $this->when($this->created_at, function () {
                return $this->created_at->isAfter(now()->subMinutes(5));
            }),
            'is_today' => $this->when($this->created_at, function () {
                return $this->created_at->isToday();
            }),
            'is_yesterday' => $this->when($this->created_at, function () {
                return $this->created_at->isYesterday();
            }),
        ];
    }
}
