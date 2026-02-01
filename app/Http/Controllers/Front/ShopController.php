<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Artisan;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_published', true)
            ->with(['category', 'artisan', 'images']);

        // Filtrage par catégorie
        if ($request->filled('category')) {
            $query->whereIn('category_id', (array) $request->category);
        }

        // Filtrage par artisan
        if ($request->filled('artisan')) {
            $query->where('artisan_id', $request->artisan);
        }

        // Filtrage par prix
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price * 100); // Prix en centimes
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price * 100);
        }

        // Recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
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
            default: // latest
                $query->latest();
                break;
        }

        $products = $query->paginate(12);

        // Pour les filtres
        $categories = Category::active()
            ->withCount(['products' => function($query) {
                $query->where('is_published', true);
            }])
            ->orderBy('name')
            ->get();

        $artisans = Artisan::where('is_approved', true)
            ->withCount(['products' => function($query) {
                $query->where('is_published', true);
            }])
            ->having('products_count', '>', 0)
            ->orderBy('shop_name')
            ->get();

        return view('front.shop.index', compact(
            'products',
            'categories',
            'artisans'
        ));
    }
}