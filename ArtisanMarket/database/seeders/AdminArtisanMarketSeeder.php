<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminArtisanMarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer l'admin avec l'email artisanmarket.com
        $admin = User::create([
            'name' => 'Admin ArtisanMarket',
            'email' => 'admin@artisanmarket.com',
            'password' => bcrypt('password'),
        ]);

        // Assigner le rôle admin
        $admin->assignRole('admin');

        $this->command->info('✅ Admin créé : admin@artisanmarket.com / password');
    }
}
