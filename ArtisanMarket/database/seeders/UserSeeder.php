<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 5 clients
        for ($i = 1; $i <= 5; $i++) {
            $client = User::create([
                'name' => 'Client ' . $i,
                'email' => 'client' . $i . '@example.com',
                'password' => bcrypt('password'),
            ]);
            $client->assignRole('client');
        }

        // Créer 8 artisans
        for ($i = 1; $i <= 8; $i++) {
            $artisan = User::create([
                'name' => 'Artisan ' . $i,
                'email' => 'artisan' . $i . '@example.com',
                'password' => bcrypt('password'),
            ]);
            $artisan->assignRole('artisan');
        }

        $this->command->info('✅ 5 clients et 8 artisans créés');
    }
}
