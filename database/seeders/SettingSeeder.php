<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Rencontre Hub'
            ],
            [
                'key' => 'app_description',
                'value' => 'L\'application de rencontres africaine qui vous connecte'
            ],
            [
                'key' => 'default_country',
                'value' => 'CIV'
            ],
            [
                'key' => 'default_city',
                'value' => 'Abidjan'
            ],
            [
                'key' => 'max_photos_per_user',
                'value' => '6'
            ],
            [
                'key' => 'max_age',
                'value' => '100'
            ],
            [
                'key' => 'min_age',
                'value' => '18'
            ],
            [
                'key' => 'max_distance',
                'value' => '100'
            ],
            [
                'key' => 'free_likes_per_day',
                'value' => '5'
            ],
            [
                'key' => 'free_messages_per_day',
                'value' => '10'
            ],
            [
                'key' => 'verification_required',
                'value' => 'false'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false'
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'L\'application est en maintenance. Nous revenons bientôt !'
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@rencontre-hub.com'
            ],
            [
                'key' => 'support_email',
                'value' => 'support@rencontre-hub.com'
            ],
            [
                'key' => 'privacy_policy_url',
                'value' => 'https://rencontre-hub.com/privacy'
            ],
            [
                'key' => 'terms_of_service_url',
                'value' => 'https://rencontre-hub.com/terms'
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/rencontre-hub'
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/rencontre-hub'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/rencontre-hub'
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com/rencontre-hub'
            ],
            [
                'key' => 'tiktok_url',
                'value' => 'https://tiktok.com/@rencontre-hub'
            ],
            [
                'key' => 'app_version',
                'value' => '1.0.0'
            ],
            [
                'key' => 'api_version',
                'value' => 'v1'
            ],
            [
                'key' => 'currency',
                'value' => 'XOF'
            ],
            [
                'key' => 'timezone',
                'value' => 'Africa/Abidjan'
            ],
            [
                'key' => 'language',
                'value' => 'fr'
            ],
            [
                'key' => 'theme_color',
                'value' => '#FF6B6B'
            ],
            [
                'key' => 'logo_url',
                'value' => '/images/logo.png'
            ],
            [
                'key' => 'favicon_url',
                'value' => '/images/favicon.ico'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
