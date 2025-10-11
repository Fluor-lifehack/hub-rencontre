<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'duration_days' => $this->duration_days,
            'tag' => $this->tag,
            'advantages' => $this->advantages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'subscriptions' => $this->whenLoaded('subscriptions'),

            // Compteurs
            'subscriptions_count' => $this->when(isset($this->subscriptions_count), $this->subscriptions_count),
            'active_subscriptions_count' => $this->when(isset($this->active_subscriptions_count), $this->active_subscriptions_count),

            // Données calculées
            'price_formatted' => $this->when($this->price, function () {
                return number_format($this->price, 0, ',', ' ').' FCFA';
            }),
            'duration_formatted' => $this->when($this->duration_days, function () {
                if ($this->duration_days == 0) {
                    return 'Gratuit';
                }
                if ($this->duration_days == 30) {
                    return '1 mois';
                }
                if ($this->duration_days == 365) {
                    return '1 an';
                }
                if ($this->duration_days < 30) {
                    return $this->duration_days.' jours';
                }
                if ($this->duration_days < 365) {
                    return round($this->duration_days / 30).' mois';
                }

                return round($this->duration_days / 365).' an(s)';
            }),
            'price_per_day' => $this->when($this->price && $this->duration_days > 0, function () {
                return round($this->price / $this->duration_days, 2);
            }),
            'is_popular' => $this->when($this->tag, function () {
                return in_array($this->tag, ['premium', 'premium-plus']);
            }),
            'badge_color' => $this->when($this->tag, function () {
                $colors = [
                    'gratuit' => 'gray',
                    'premium' => 'blue',
                    'premium-plus' => 'purple',
                    'vip' => 'gold',
                    'premium-annuel' => 'green',
                    'premium-plus-annuel' => 'green',
                ];

                return $colors[$this->tag] ?? 'gray';
            }),
        ];
    }
}
