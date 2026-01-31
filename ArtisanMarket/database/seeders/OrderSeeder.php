<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $clients = User::role('client')->get();
        $products = Product::where('is_published', true)->get();

        if ($clients->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠ Aucun client ou produit publié disponible');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered'];

        foreach ($clients as $client) {
            // 1-2 commandes par client
            for ($i = 1; $i <= rand(1, 2); $i++) {
                // Sélectionner un artisan aléatoire pour cette commande
                $randomProduct = $products->random();
                $artisanId = $randomProduct->artisan_id;
                
                $order = Order::create([
                    'user_id' => $client->id,
                    'artisan_id' => $artisanId,
                    'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
                    'status' => $statuses[array_rand($statuses)],
                    'total_amount' => 0,
                    'shipping_address' => $client->name . ', ' . rand(1, 100) . ' Rue Exemple, Paris 75001',
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                // 1-3 produits par commande (du même artisan)
                $artisanProducts = $products->where('artisan_id', $artisanId);
                $total = 0;
                for ($j = 1; $j <= rand(1, 3); $j++) {
                    if ($artisanProducts->isEmpty()) break;
                    
                    $product = $artisanProducts->random();
                    $quantity = rand(1, 3);
                    $unitPrice = $product->price;
                    $subtotal = $unitPrice * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                $order->update(['total_amount' => $total]);
            }
        }

        $this->command->info('✅ ' . Order::count() . ' commandes créées');
    }
}
