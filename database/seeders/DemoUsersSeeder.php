<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un artisan de démo
        $artisan = User::firstOrCreate(
            ['email' => 'artisan@test.com'],
            [
                'name' => 'Artisan Démo',
                'password' => Hash::make('password'),
            ]
        );

        if (!$artisan->hasRole('artisan')) {
            $artisan->assignRole('artisan');
        }

        // Créer un client de démo
        $client = User::firstOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Client Démo',
                'password' => Hash::make('password'),
            ]
        );

        if (!$client->hasRole('client')) {
            $client->assignRole('client');
        }

        $this->command->info('✅ Utilisateurs de démo créés avec succès');
        $this->command->info('');
        $this->command->info('🔐 Comptes disponibles:');
        $this->command->info('');
        $this->command->info('Admin:');
        $this->command->info('  Email: admin@artisanmarket.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('Artisan:');
        $this->command->info('  Email: artisan@test.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('Client:');
        $this->command->info('  Email: client@test.com');
        $this->command->info('  Password: password');
    }
}
