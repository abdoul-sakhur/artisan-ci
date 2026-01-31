<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer l'utilisateur admin par défaut
        $admin = User::firstOrCreate(
            ['email' => 'admin@artisanmarket.com'],
            [
                'name' => 'Admin ArtisanMarket',
                'password' => Hash::make('password'),
            ]
        );

        // Assigner le rôle admin
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('✅ Admin créé avec succès');
        $this->command->info('Email: admin@artisanmarket.com');
        $this->command->info('Password: password');
    }
}
