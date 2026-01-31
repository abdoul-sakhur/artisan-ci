<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        return [
            'order_number' => 'ORD-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'user_id' => \App\Models\User::factory(),
            'artisan_id' => \App\Models\Artisan::factory(),
            'total_amount' => fake()->randomFloat(2, 20, 1000),
            'status' => fake()->randomElement($statuses),
            'shipping_address' => [
                'name' => fake()->name(),
                'address' => fake()->streetAddress(),
                'city' => fake()->city(),
                'postal_code' => fake()->postcode(),
                'country' => 'France',
                'phone' => fake()->phoneNumber(),
            ],
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

