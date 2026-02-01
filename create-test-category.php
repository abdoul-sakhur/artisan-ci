<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$cat = Category::create([
    'name' => 'Catégorie Test',
    'slug' => 'categorie-test',
    'description' => 'Catégorie de test sans produits',
    'is_active' => true
]);

echo "Catégorie créée: ID {$cat->id}\n";
