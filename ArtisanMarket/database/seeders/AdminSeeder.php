<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Crée un compte administrateur par défaut pour accéder à la plateforme.
     * Email: admin@artisanmarket.com
     * Password: password
     * 
     * ⚠️ IMPORTANT : Changez ce mot de passe en production !
     */
    public function run(): void
    {
        // Vérifier si l'admin existe déjà
        $adminEmail = 'admin@artisanmarket.com';
        
        $admin = User::where('email', $adminEmail)->first();

        if ($admin) {
            $this->command->warn("⚠ L'administrateur existe déjà : {$adminEmail}");
            
            // S'assurer qu'il a bien le rôle admin
            if (!$admin->hasRole('admin')) {
                $admin->assignRole('admin');
                $this->command->info("✓ Rôle 'admin' assigné à l'utilisateur existant");
            }
        } else {
            // Créer le nouvel administrateur
            $admin = User::create([
                'name' => 'Administrateur',
                'email' => $adminEmail,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            // Assigner le rôle admin
            $admin->assignRole('admin');

            $this->command->info('✓ Administrateur créé avec succès !');
            $this->command->info("   Email: {$adminEmail}");
            $this->command->info("   Password: password");
            $this->command->warn('   ⚠️ Changez ce mot de passe en production !');
        }
    }
}
