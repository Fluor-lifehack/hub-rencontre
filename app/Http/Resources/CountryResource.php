<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'cities' => $this->whenLoaded('cities', function () {
                return $this->cities->map(function ($city) {
                    return [
                        'id' => $city->uuid,
                        'name' => $city->name,
                        'country_id' => $city->country->uuid,
                    ];
                });
            }),

            // Compteurs
            'cities_count' => $this->when(isset($this->cities_count), $this->cities_count),
            'profiles_count' => $this->when(isset($this->profiles_count), $this->profiles_count),

            // Données calculées
            'flag_emoji' => $this->when($this->code, function () {
                // Mapping simple des codes pays vers emojis de drapeaux
                $flagMap = [
                    'CIV' => '🇨🇮',
                    'SEN' => '🇸🇳',
                    'MLI' => '🇲🇱',
                    'BFA' => '🇧🇫',
                    'GHA' => '🇬🇭',
                    'NGA' => '🇳🇬',
                    'CMR' => '🇨🇲',
                    'GAB' => '🇬🇦',
                    'COG' => '🇨🇬',
                    'COD' => '🇨🇩',
                    'TCD' => '🇹🇩',
                    'CAF' => '🇨🇫',
                    'GIN' => '🇬🇳',
                    'GNB' => '🇬🇼',
                    'SLE' => '🇸🇱',
                ];

                return $flagMap[$this->code] ?? '🏳️';
            }),
        ];
    }
}
