<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Initialise les 3 rôles principaux de la plateforme ArtisanMarket :
     * - admin : Gestion complète de la plateforme
     * - artisan : Gestion des produits et commandes
     * - client : Navigation et achat de produits
     */
    public function run(): void
    {
        // Réinitialiser le cache des rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des 3 rôles principaux
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrateur de la plateforme avec accès complet'
            ],
            [
                'name' => 'artisan',
                'description' => 'Artisan vendeur pouvant gérer ses produits et commandes'
            ],
            [
                'name' => 'client',
                'description' => 'Client acheteur pouvant parcourir et acheter des produits'
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                ['guard_name' => 'web']
            );
            
            $this->command->info("✓ Rôle '{$roleData['name']}' créé avec succès");
        }

        // Création des permissions de base (optionnel - à étendre selon les besoins)
        $permissions = [
            // Permissions Admin
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'view-dashboard-admin',
            
            // Permissions Artisan
            'manage-own-products',
            'manage-own-orders',
            'view-dashboard-artisan',
            
            // Permissions Client
            'browse-products',
            'make-purchase',
            'view-own-orders',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        // Assignation des permissions aux rôles
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all()); // Admin a toutes les permissions

        $artisanRole = Role::findByName('artisan');
        $artisanRole->givePermissionTo([
            'manage-own-products',
            'manage-own-orders',
            'view-dashboard-artisan',
            'browse-products',
        ]);

        $clientRole = Role::findByName('client');
        $clientRole->givePermissionTo([
            'browse-products',
            'make-purchase',
            'view-own-orders',
        ]);

        $this->command->info('✓ Tous les rôles et permissions ont été créés avec succès !');
    }
}
