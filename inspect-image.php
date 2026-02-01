<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

$p = Product::with('images')->latest()->first();
if (!$p) { echo "no product\n"; exit; }
$img = $p->images->first();
if (!$img) { echo "no image\n"; exit; }

echo "DB path: {$img->path}\n";
echo "URL: ".Storage::disk('public')->url($img->path)."\n";
