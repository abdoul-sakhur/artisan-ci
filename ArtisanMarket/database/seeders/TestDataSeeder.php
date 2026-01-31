<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artisan;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des clients de test
        $clients = [];
        for ($i = 1; $i <= 5; $i++) {
            $client = User::create([
                'name' => "Client Test $i",
                'email' => "client$i@test.com",
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $client->assignRole('client');
            $clients[] = $client;
        }

        // Créer des artisans de test (certains approuvés, d'autres en attente)
        $artisans = [];
        for ($i = 1; $i <= 8; $i++) {
            $user = User::create([
                'name' => "Artisan Test $i",
                'email' => "artisan$i@test.com",
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('artisan');

            $isApproved = $i <= 5; // Les 5 premiers sont approuvés
            $artisan = Artisan::create([
                'user_id' => $user->id,
                'shop_name' => "Atelier Artisan $i",
                'shop_description' => "Description de l'atelier artisan numéro $i. Créations artisanales uniques et authentiques.",
                'is_approved' => $isApproved,
                'approved_at' => $isApproved ? now()->subDays(rand(1, 30)) : null,
            ]);
            
            if ($isApproved) {
                $artisans[] = $artisan;
            }
        }

        // Créer des produits pour les artisans approuvés
        $categories = Category::all();
        foreach ($artisans as $artisan) {
            $productsCount = rand(3, 8);
            
            for ($j = 1; $j <= $productsCount; $j++) {
                $category = $categories->random();
                $isPublished = rand(0, 10) > 2; // 80% publiés
                $isFeatured = $isPublished && rand(0, 10) > 7; // 30% en vedette parmi les publiés
                
                $product = Product::create([
                    'artisan_id' => $artisan->id,
                    'category_id' => $category->id,
                    'name' => "Produit {$category->name} $j - {$artisan->shop_name}",
                    'slug' => Str::slug("Produit {$category->name} $j {$artisan->shop_name}"),
                    'description' => "Description détaillée du produit artisanal de la catégorie {$category->name}. Fait main avec passion et savoir-faire.",
                    'price' => rand(10, 200) + (rand(0, 99) / 100),
                    'quantity' => rand(1, 50),
                    'is_published' => $isPublished,
                    'is_featured' => $isFeatured,
                    'views_count' => rand(0, 500),
                ]);
            }
        }

        // Créer quelques commandes
        $products = Product::where('is_published', true)->get();
        
        if ($products->count() > 0) {
            foreach ($clients as $client) {
                $ordersCount = rand(1, 3);
                
                for ($k = 0; $k < $ordersCount; $k++) {
                    // Sélectionner aléatoirement un artisan
                    $artisan = $artisans[array_rand($artisans)];
                    
                    // Créer la commande
                    $status = ['pending', 'processing', 'shipped', 'delivered'][rand(0, 3)];
                    $order = Order::create([
                        'user_id' => $client->id,
                        'artisan_id' => $artisan->id,
                        'order_number' => Order::generateOrderNumber(),
                        'total_amount' => 0, // Will be calculated
                        'status' => $status,
                        'shipping_address' => "123 Rue Test, 75000 Paris",
                        'notes' => $status === 'pending' ? 'Commande en attente de traitement' : null,
                    ]);
                    
                    // Ajouter des articles à la commande
                    $itemsCount = rand(1, 4);
                    $totalAmount = 0;
                    
                    for ($l = 0; $l < $itemsCount; $l++) {
                        $product = $products->random();
                        $quantity = rand(1, 3);
                        $subtotal = $product->price * $quantity;
                        
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $product->price,
                            'subtotal' => $subtotal,
                        ]);
                        
                        $totalAmount += $subtotal;
                    }
                    
                    // Mettre à jour le total de la commande
                    $order->update(['total_amount' => $totalAmount]);
                }
            }
        }

        $this->command->info('✅ Données de test créées avec succès !');
        $this->command->info("   - 5 clients");
        $this->command->info("   - 8 artisans (5 approuvés, 3 en attente)");
        $this->command->info("   - " . Product::count() . " produits");
        $this->command->info("   - " . Order::count() . " commandes");
    }
}

