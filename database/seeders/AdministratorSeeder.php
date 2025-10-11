<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::create([
            'name' => 'Super Admin',
            'email' => 'admin@rencontre-hub.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        Administrator::create([
            'name' => 'Moderator',
            'email' => 'moderator@rencontre-hub.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
