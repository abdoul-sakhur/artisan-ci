<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artisan>
 */
class ArtisanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shopName = fake()->company() . ' Artisan';
        
        return [
            'user_id' => \App\Models\User::factory(),
            'shop_name' => $shopName,
            'shop_slug' => \Illuminate\Support\Str::slug($shopName),
            'shop_description' => fake()->paragraph(3),
            'shop_logo' => null,
            'shop_banner' => null,
            'is_approved' => fake()->boolean(70), // 70% approuvés
            'approved_at' => function (array $attributes) {
                return $attributes['is_approved'] ? now()->subDays(rand(1, 30)) : null;
            },
            'approved_by' => function (array $attributes) {
                return $attributes['is_approved'] ? 1 : null; // Admin ID
            },
        ];
    }

    /**
     * Indiquer que l'artisan est approuvé
     */
    public function approved()
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
            'approved_at' => now()->subDays(rand(1, 30)),
            'approved_by' => 1,
        ]);
    }

    /**
     * Indiquer que l'artisan est en attente
     */
    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
            'approved_at' => null,
            'approved_by' => null,
        ]);
    }
}

