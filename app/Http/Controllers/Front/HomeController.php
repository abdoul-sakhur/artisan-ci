<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Artisan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Produits en vedette (avec images)
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_published', true)
            ->with(['category', 'artisan', 'images'])
            ->latest()
            ->limit(8)
            ->get();

        // Nouveaux produits
        $newProducts = Product::where('is_published', true)
            ->with(['category', 'artisan', 'images'])
            ->latest()
            ->limit(8)
            ->get();

        // Catégories populaires (avec nombre de produits)
        $categories = Category::withCount(['products' => function($query) {
            $query->where('is_published', true);
        }])
            ->having('products_count', '>', 0)
            ->orderBy('products_count', 'desc')
            ->limit(6)
            ->get();

        // Artisans récemment approuvés
        $artisans = Artisan::where('is_approved', true)
            ->withCount(['products' => function($query) {
                $query->where('is_published', true);
            }])
            ->having('products_count', '>', 0)
            ->latest('approved_at')
            ->limit(6)
            ->get();

        return view('front.home', compact(
            'featuredProducts',
            'newProducts',
            'categories',
            'artisans'
        ));
    }
}