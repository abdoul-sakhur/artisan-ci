<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artisan;

class ArtisanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 5 artisans approuvés
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "artisan.demo$i@test.com"],
                [
                    'name' => "Artisan Démo $i",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->hasRole('artisan')) {
                $user->assignRole('artisan');
            }

            Artisan::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'shop_name' => "Boutique Artisan $i",
                    'shop_slug' => "boutique-artisan-$i",
                    'shop_description' => "Artisan passionné spécialisé dans l'artisanat traditionnel.",
                    'shop_logo' => "https://ui-avatars.com/api/?name=Artisan+$i&background=random",
                    'shop_banner' => "https://picsum.photos/seed/artisan$i/1200/400",
                    'is_approved' => true,
                    'approved_at' => now()->subDays(rand(1, 30)),
                    'approved_by' => 1, // ID de l'admin
                ]
            );
        }

        // Créer 3 artisans en attente
        for ($i = 1; $i <= 3; $i++) {
            $user = User::firstOrCreate(
                ['email' => "artisan.nouveau$i@test.com"],
                [
                    'name' => "Artisan Nouveau $i",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->hasRole('artisan')) {
                $user->assignRole('artisan');
            }

            Artisan::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'shop_name' => "Nouvelle Boutique $i",
                    'shop_slug' => "nouvelle-boutique-$i",
                    'shop_description' => "Nouvel artisan souhaitant rejoindre la plateforme.",
                    'shop_logo' => "https://ui-avatars.com/api/?name=Nouveau+$i&background=random",
                    'is_approved' => false,
                ]
            );
        }

        $this->command->info('✅ 8 artisans créés (5 approuvés, 3 en attente)');
    }
}
