<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Artisan;

class ShopController extends Controller
{
    /**
     * Affiche le catalogue de produits
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'artisan', 'images'])
            ->where('is_published', true)
            ->where('quantity', '>', 0);

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filtre par artisan
        if ($request->filled('artisan')) {
            $query->where('artisan_id', $request->artisan);
        }

        // Recherche par nom ou description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par prix
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Tri
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);
        
        // Pour les filtres
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_published', true)->where('quantity', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        $artisans = Artisan::where('is_approved', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_published', true)->where('quantity', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->orderBy('shop_name')
            ->get();

        return view('shop.index', compact('products', 'categories', 'artisans', 'sort'));
    }

    /**
     * Affiche les détails d'un produit
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'artisan.user', 'images'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Incrémenter le compteur de vues
        $product->incrementViews();

        // Produits similaires (même catégorie)
        $relatedProducts = Product::with(['category', 'artisan', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->where('quantity', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Autres produits du même artisan
        $artisanProducts = Product::with(['category', 'images'])
            ->where('artisan_id', $product->artisan_id)
            ->where('id', '!=', $product->id)
            ->where('is_published', true)
            ->where('quantity', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts', 'artisanProducts'));
    }
}
