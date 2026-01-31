<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artisan;

class ArtisanSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les utilisateurs avec le rôle artisan
        $artisanUsers = User::role('artisan')->get();

        foreach ($artisanUsers as $index => $user) {
            Artisan::create([
                'user_id' => $user->id,
                'shop_name' => 'Boutique ' . $user->name,
                'shop_description' => 'Créations artisanales uniques de ' . $user->name,
                'is_approved' => $index < 6, // Les 6 premiers sont approuvés
            ]);
        }

        $this->command->info('✅ ' . $artisanUsers->count() . ' profils artisans créés');
    }
}
