<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Poterie & Céramique',
                'slug' => 'poterie-ceramique',
                'description' => 'Objets en céramique faits main, poteries artisanales, vases et décorations',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Bijoux Artisanaux',
                'slug' => 'bijoux-artisanaux',
                'description' => 'Bijoux faits main, colliers, bracelets, boucles d\'oreilles uniques',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Maroquinerie',
                'slug' => 'maroquinerie',
                'description' => 'Sacs en cuir, portefeuilles, ceintures et accessoires en cuir',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Textile & Broderie',
                'slug' => 'textile-broderie',
                'description' => 'Vêtements brodés, textiles artisanaux, tissages et tapisseries',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Bois Sculpté',
                'slug' => 'bois-sculpte',
                'description' => 'Sculptures en bois, objets décoratifs, meubles artisanaux',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Verrerie',
                'slug' => 'verrerie',
                'description' => 'Objets en verre soufflé, vitraux, décorations en verre',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Peinture & Art Mural',
                'slug' => 'peinture-art-mural',
                'description' => 'Tableaux, peintures originales, art mural et fresques',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Vannerie',
                'slug' => 'vannerie',
                'description' => 'Paniers tressés, objets en osier, décorations en rotin',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Savons & Cosmétiques',
                'slug' => 'savons-cosmetiques',
                'description' => 'Savons artisanaux, cosmétiques naturels, produits de beauté faits main',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Décoration Intérieure',
                'slug' => 'decoration-interieure',
                'description' => 'Objets décoratifs, accessoires pour la maison, artisanat décoratif',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ 10 catégories créées avec succès');
    }
}
