<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Gratuit',
                'description' => 'Plan de base gratuit avec fonctionnalités limitées',
                'price' => 0.00,
                'duration_days' => 0,
                'tag' => 'gratuit',
                'advantages' => [
                    'Profil de base',
                    '5 likes par jour',
                    'Recherche basique',
                    'Messages limités',
                ],
            ],
            [
                'name' => 'Premium',
                'description' => 'Plan premium avec fonctionnalités avancées',
                'price' => 6500,
                'duration_days' => 30,
                'tag' => 'premium',
                'advantages' => [
                    'Profil illimité',
                    'Likes illimités',
                    'Recherche avancée',
                    'Messages illimités',
                    'Voir qui vous a liké',
                    'Priorité dans les résultats',
                ],
            ],
            [
                'name' => 'Premium Plus',
                'description' => 'Plan premium plus avec fonctionnalités exclusives',
                'price' => 13000,
                'duration_days' => 30,
                'tag' => 'premium-plus',
                'advantages' => [
                    'Toutes les fonctionnalités Premium',
                    'Boost de profil',
                    'Super likes',
                    'Passport (changer de localisation)',
                    'Statistiques détaillées',
                    'Support prioritaire',
                ],
            ],
            [
                'name' => 'VIP',
                'description' => 'Plan VIP avec fonctionnalités exclusives et support dédié',
                'price' => 32500,
                'duration_days' => 30,
                'tag' => 'vip',
                'advantages' => [
                    'Toutes les fonctionnalités Premium Plus',
                    'Badge VIP',
                    'Accès aux événements exclusifs',
                    'Conseiller personnel',
                    'Fonctionnalités beta',
                    'Support 24/7',
                ],
            ],
            [
                'name' => 'Premium Annuel',
                'description' => 'Plan premium avec réduction annuelle',
                'price' => 65000,
                'duration_days' => 365,
                'tag' => 'premium-annuel',
                'advantages' => [
                    'Toutes les fonctionnalités Premium',
                    'Économie de 17%',
                    'Badge membre fidèle',
                    'Accès aux fonctionnalités futures',
                ],
            ],
            [
                'name' => 'Premium Plus Annuel',
                'description' => 'Plan premium plus avec réduction annuelle',
                'price' => 130000,
                'duration_days' => 365,
                'tag' => 'premium-plus-annuel',
                'advantages' => [
                    'Toutes les fonctionnalités Premium Plus',
                    'Économie de 17%',
                    'Badge membre fidèle',
                    'Accès aux fonctionnalités futures',
                    'Support prioritaire',
                ],
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
