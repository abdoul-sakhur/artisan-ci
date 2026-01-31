<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Artisan;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $artisans = Artisan::all();
        $categories = Category::all();

        foreach ($artisans as $artisan) {
            // 3 produits par artisan
            for ($i = 1; $i <= 3; $i++) {
                $product = Product::create([
                    'artisan_id' => $artisan->id,
                    'category_id' => $categories->random()->id,
                    'name' => 'Produit ' . $i . ' de ' . $artisan->shop_name,
                    'slug' => \Illuminate\Support\Str::slug('Produit ' . $i . ' de ' . $artisan->shop_name . ' ' . time() . rand(1000, 9999)),
                    'description' => 'Description détaillée du produit artisanal numéro ' . $i,
                    'price' => rand(50, 500),
                    'quantity' => rand(1, 20),
                    'is_published' => rand(0, 1),
                    'views_count' => rand(0, 100),
                ]);

                // 1-2 images par produit
                for ($j = 1; $j <= rand(1, 2); $j++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'products/placeholder.jpg',
                        'sort_order' => $j,
                        'is_primary' => $j === 1,
                    ]);
                }
            }
        }

        $this->command->info('✅ ' . ($artisans->count() * 3) . ' produits créés');
    }
}
