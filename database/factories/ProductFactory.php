<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productNames = [
            'Vase en Céramique', 'Collier Artisanal', 'Sac en Cuir', 'Écharpe Brodée',
            'Sculpture en Bois', 'Verre Soufflé', 'Tableau Abstrait', 'Panier Tressé',
            'Savon Lavande', 'Bougeoir Décoratif', 'Tasse en Grès', 'Bracelet Argent',
            'Portefeuille Cuir', 'Coussin Brodé', 'Statuette Bois', 'Photophore Verre',
            'Aquarelle Paysage', 'Corbeille Osier', 'Huile Essentielle', 'Cadre Photo'
        ];
        
        $name = fake()->randomElement($productNames) . ' ' . fake()->word();
        
        return [
            'artisan_id' => \App\Models\Artisan::factory(),
            'category_id' => function () {
                return \App\Models\Category::inRandomOrder()->first()?->id ?? 1;
            },
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(5),
            'price' => fake()->randomFloat(2, 10, 500),
            'quantity' => fake()->numberBetween(0, 50),
            'sku' => 'SKU-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'is_published' => fake()->boolean(80), // 80% publiés
            'is_featured' => fake()->boolean(20), // 20% en vedette
            'views_count' => fake()->numberBetween(0, 1000),
        ];
    }

    /**
     * Produit publié
     */
    public function published()
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Produit en vedette
     */
    public function featured()
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'is_featured' => true,
        ]);
    }

    /**
     * Produit en rupture de stock
     */
    public function outOfStock()
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }
}

