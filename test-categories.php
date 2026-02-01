<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

echo "Liste des catégories et nombre de produits:\n\n";

$categories = Category::withCount('products')->get();

foreach ($categories as $category) {
    echo "ID: {$category->id} | {$category->name} | {$category->products_count} produits\n";
}
