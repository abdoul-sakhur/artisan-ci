<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Artisan;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil publique
     */
    public function index()
    {
        // Produits en vedette (featured)
        $featuredProducts = Product::with(['category', 'artisan', 'images'])
            ->where('is_published', true)
            ->where('is_featured', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        // Nouveaux produits
        $newProducts = Product::with(['category', 'artisan', 'images'])
            ->where('is_published', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        // Catégories avec nombre de produits
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_published', true)->where('quantity', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->take(8)
            ->get();

        // Artisans approuvés avec produits
        $artisans = Artisan::where('is_approved', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_published', true)->where('quantity', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'newProducts', 'categories', 'artisans'));
    }
}
