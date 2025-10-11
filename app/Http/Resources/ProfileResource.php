<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'user_id' => $this->when($this->user, $this->user->uuid),
            'bio' => $this->bio,
            'gender' => $this->gender,
            'age' => $this->age,
            'country_id' => $this->whenLoaded('country', function () {
                return $this->country->uuid;
            }),
            'city_id' => $this->whenLoaded('city', function () {
                return $this->city->uuid;
            }),
            'height' => $this->height,
            'hobbies' => $this->hobbies,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'user' => new UserResource($this->whenLoaded('user')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'city' => $this->whenLoaded('city', function () {
                return [
                    'id' => $this->city->uuid,
                    'name' => $this->city->name,
                    'country_id' => $this->city->country->uuid,
                ];
            }),

            // Données calculées
            'age_group' => $this->when($this->age, function () {
                if ($this->age < 25) {
                    return '18-24';
                }
                if ($this->age < 35) {
                    return '25-34';
                }
                if ($this->age < 45) {
                    return '35-44';
                }
                if ($this->age < 55) {
                    return '45-54';
                }

                return '55+';
            }),
            'height_formatted' => $this->when($this->height, function () {
                return $this->height.' cm';
            }),
        ];
    }
}
