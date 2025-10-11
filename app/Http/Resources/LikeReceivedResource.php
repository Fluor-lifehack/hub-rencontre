<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeReceivedResource extends JsonResource
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
            'liker_id' => $this->whenLoaded('user', $this->user->uuid),
            'compatibility_score' => $this->compatibility_score,
            'is_mutual' => $this->is_mutual,
            'liked_at' => $this->created_at,

            // Informations du profil qui a liké
            'liker' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->uuid,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'phone' => $this->user->phone,
                    'profile' => $this->whenLoaded('user.profile', function () {
                        return [
                            'id' => $this->user->profile->uuid,
                            'bio' => $this->user->profile->bio,
                            'gender' => $this->user->profile->gender,
                            'age' => $this->user->profile->age,
                            'height' => $this->user->profile->height,
                            'hobbies' => $this->user->profile->hobbies,
                            'avatar' => $this->user->profile->avatar,
                            'country' => $this->whenLoaded('user.profile.country', function () {
                                return [
                                    'id' => $this->user->profile->country->uuid,
                                    'name' => $this->user->profile->country->name,
                                    'code' => $this->user->profile->country->code,
                                ];
                            }),
                            'city' => $this->whenLoaded('user.profile.city', function () {
                                return [
                                    'id' => $this->user->profile->city->uuid,
                                    'name' => $this->user->profile->city->name,
                                ];
                            }),
                        ];
                    }),
                    'photos' => $this->whenLoaded('user.photos', function () {
                        return $this->user->photos->map(function ($photo) {
                            return [
                                'id' => $photo->uuid,
                                'path' => $photo->path,
                                'is_profile' => $photo->is_profile,
                                'url' => $photo->path ? asset('storage/' . $photo->path) : null,
                            ];
                        });
                    }),
                ];
            }),

            // Propriétés calculées
            'compatibility_level' => $this->getCompatibilityLevel(),
            'time_ago' => $this->created_at->diffForHumans(),
            'is_recent' => $this->created_at->isToday(),
        ];
    }

    /**
     * Détermine le niveau de compatibilité basé sur le score
     */
    private function getCompatibilityLevel(): string
    {
        return match (true) {
            $this->compatibility_score >= 80 => 'Très élevée',
            $this->compatibility_score >= 60 => 'Élevée',
            $this->compatibility_score >= 40 => 'Moyenne',
            default => 'Faible',
        };
    }
}
