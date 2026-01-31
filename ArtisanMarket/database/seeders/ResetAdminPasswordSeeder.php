<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ResetAdminPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@artisanmarket.com')->first();

        if ($admin) {
            $admin->update([
                'password' => bcrypt('password'),
            ]);
            $this->command->info('✅ Mot de passe réinitialisé pour admin@artisanmarket.com');
        } else {
            $this->command->error('❌ Admin non trouvé');
        }
    }
}
