<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Céramique',
                'description' => 'Poterie, vaisselle artisanale, objets décoratifs en céramique',
                'is_active' => true,
            ],
            [
                'name' => 'Textile',
                'description' => 'Tissage, broderie, tapisserie et créations textiles artisanales',
                'is_active' => true,
            ],
            [
                'name' => 'Bijoux',
                'description' => 'Bijouterie artisanale, accessoires faits main',
                'is_active' => true,
            ],
            [
                'name' => 'Décoration',
                'description' => 'Objets décoratifs, art mural, sculptures décoratives',
                'is_active' => true,
            ],
            [
                'name' => 'Maroquinerie',
                'description' => 'Sacs, portefeuilles, ceintures en cuir travaillé',
                'is_active' => true,
            ],
            [
                'name' => 'Bois',
                'description' => 'Menuiserie, sculpture sur bois, mobilier artisanal',
                'is_active' => true,
            ],
            [
                'name' => 'Verre',
                'description' => 'Soufflage de verre, vitrail, objets en verre artisanal',
                'is_active' => true,
            ],
            [
                'name' => 'Métal',
                'description' => 'Ferronnerie, sculpture métallique, bijoux en métal',
                'is_active' => true,
            ],
            [
                'name' => 'Papeterie',
                'description' => 'Carnets, cartes, papier fait main, calligraphie',
                'is_active' => true,
            ],
            [
                'name' => 'Cosmétiques',
                'description' => 'Savons artisanaux, produits de beauté naturels',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
}
