<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
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
            'user_id' => $this->whenLoaded('user', function () {
                return $this->user->uuid;
            }),
            'matched_user_id' => $this->whenLoaded('matchedUser', function () {
                return $this->matchedUser->uuid;
            }),
            'compatibility_score' => $this->compatibility_score,
            'is_mutual' => $this->is_mutual,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'user' => new UserResource($this->whenLoaded('user')),
            'matched_user' => new UserResource($this->whenLoaded('matchedUser')),
            'user_profile' => new ProfileResource($this->whenLoaded('user.profile')),
            'matched_user_profile' => new ProfileResource($this->whenLoaded('matchedUser.profile')),

            // Données calculées
            'compatibility_level' => $this->when($this->compatibility_score, function () {
                if ($this->compatibility_score >= 90) {
                    return 'excellent';
                }
                if ($this->compatibility_score >= 80) {
                    return 'très bon';
                }
                if ($this->compatibility_score >= 70) {
                    return 'bon';
                }
                if ($this->compatibility_score >= 60) {
                    return 'correct';
                }

                return 'faible';
            }),
            'match_age' => $this->when($this->created_at, function () {
                return $this->created_at->diffForHumans();
            }),
        ];
    }
}
