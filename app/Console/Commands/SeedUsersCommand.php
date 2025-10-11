<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:users {--count=1000 : Number of users to create} {--realistic : Create realistic users with detailed profiles}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with users for the dating app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Démarrage des seeders Rencontre Hub...');

        // Nettoyer la base de données
        if ($this->confirm('Voulez-vous nettoyer la base de données avant de créer les utilisateurs ?', true)) {
            $this->info('🧹 Nettoyage de la base de données...');
            Artisan::call('migrate:fresh');
        }

        // Exécuter les seeders de base
        $this->info('📊 Exécution des seeders de base...');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);

        // Créer des utilisateurs réalistes si demandé
        if ($this->option('realistic')) {
            $this->info('👥 Création d\'utilisateurs réalistes avec profils détaillés...');
            Artisan::call('db:seed', ['--class' => 'RealisticUserSeeder']);
        } else {
            // Créer des utilisateurs avec la factory
            $count = $this->option('count');
            $this->info("👥 Création de {$count} utilisateurs...");
            Artisan::call('db:seed', ['--class' => 'UserSeeder']);

            // Créer des utilisateurs supplémentaires
            if ($count > 200) {
                $this->info('👥 Création d\'utilisateurs supplémentaires...');
                Artisan::call('db:seed', ['--class' => 'MassiveUserSeeder']);
            }
        }

        // Afficher les statistiques
        $this->displayStatistics();

        $this->info('✅ Seeders terminés avec succès!');
        $this->newLine();
        $this->info('🔗 Vous pouvez maintenant:');
        $this->info('   - Tester l\'API avec: php artisan serve');
        $this->info('   - Accéder au frontend sur: http://localhost:3000');
        $this->info('   - Utiliser les comptes de test:');
        $this->info('     * marie.dubois@example.com');
        $this->info('     * pierre.martin@example.com');
        $this->info('     * sophie.laurent@example.com');
        $this->newLine();
        $this->info('🎉 Bon développement!');
    }

    private function displayStatistics()
    {
        $this->info('📈 Statistiques de la base de données:');
        $this->info('==================================');

        // Compter les utilisateurs
        $userCount = \App\Models\User::count();
        $this->info("👤 Nombre d'utilisateurs: {$userCount}");

        // Compter les profils
        $profileCount = \App\Models\Profile::count();
        $this->info("📝 Nombre de profils: {$profileCount}");

        // Compter les pays
        $countryCount = \App\Models\Country::count();
        $this->info("🌍 Nombre de pays: {$countryCount}");

        // Compter les villes
        $cityCount = \App\Models\City::count();
        $this->info("🏙️  Nombre de villes: {$cityCount}");

        // Compter les photos
        $photoCount = \App\Models\Photo::count();
        $this->info("📸 Nombre de photos: {$photoCount}");

        // Compter les matches
        $matchCount = \App\Models\UserMatch::count();
        $this->info("💕 Nombre de matches: {$matchCount}");

        // Compter les conversations
        $conversationCount = \App\Models\Conversation::count();
        $this->info("💬 Nombre de conversations: {$conversationCount}");

        // Compter les messages
        $messageCount = \App\Models\Message::count();
        $this->info("📨 Nombre de messages: {$messageCount}");

        // Afficher la répartition par genre
        $maleCount = \App\Models\Profile::where('gender', 'male')->count();
        $femaleCount = \App\Models\Profile::where('gender', 'female')->count();
        $otherCount = \App\Models\Profile::where('gender', 'other')->count();

        $this->newLine();
        $this->info('👥 Répartition par genre:');
        $this->info("   Hommes: {$maleCount}");
        $this->info("   Femmes: {$femaleCount}");
        $this->info("   Autres: {$otherCount}");

        // Afficher la répartition par âge
        $this->newLine();
        $this->info('📊 Répartition par âge:');
        $ageGroups = [
            '18-25' => \App\Models\Profile::whereBetween('age', [18, 25])->count(),
            '26-35' => \App\Models\Profile::whereBetween('age', [26, 35])->count(),
            '36-45' => \App\Models\Profile::whereBetween('age', [36, 45])->count(),
            '46-55' => \App\Models\Profile::whereBetween('age', [46, 55])->count(),
            '56+' => \App\Models\Profile::where('age', '>', 55)->count(),
        ];

        foreach ($ageGroups as $group => $count) {
            $this->info("   {$group} ans: {$count}");
        }

        // Afficher les villes les plus représentées
        $this->newLine();
        $this->info('🏙️  Top 5 des villes:');
        $topCities = \App\Models\Profile::selectRaw('cities.name, COUNT(*) as count')
            ->join('cities', 'profiles.city_id', '=', 'cities.id')
            ->groupBy('cities.name')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        foreach ($topCities as $city) {
            $this->info("   {$city->name}: {$city->count} utilisateurs");
        }
    }
}
