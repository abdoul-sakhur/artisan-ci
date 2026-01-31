<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\RoleSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles, permissions et admin par défaut
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ArtisanSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
