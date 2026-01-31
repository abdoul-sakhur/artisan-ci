<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_published', true)
            ->with(['category', 'artisan', 'images'])
            ->firstOrFail();

        // Incrémenter le compteur de vues
        $product->increment('views_count');

        // Produits similaires (même catégorie)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->with(['images', 'artisan'])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Autres œuvres du même artisan
        $artisanProducts = Product::where('artisan_id', $product->artisan_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->with(['images', 'category'])
            ->latest()
            ->limit(4)
            ->get();

        return view('front.shop.product', compact(
            'product',
            'relatedProducts',
            'artisanProducts'
        ));
    }
}