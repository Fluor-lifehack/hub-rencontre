<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdministratorSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            PlanSeeder::class,
            SettingSeeder::class,
            UserSeeder::class, // Ajouter le seeder des utilisateurs
            RealisticUserSeeder::class, // Ajouter le seeder des utilisateurs réalistes
            MassiveUserSeeder::class, // Ajouter le seeder des utilisateurs supplémentaires

        ]);
    }
}
