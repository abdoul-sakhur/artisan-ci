<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Category;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function show($slug, Request $request)
    {
        $artisan = Artisan::where('shop_slug', $slug)
            ->where('is_approved', true)
            ->firstOrFail();

        $query = $artisan->products()
            ->where('is_published', true)
            ->with(['category', 'images']);

        // Filtrage par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
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

        // Catégories pour le filtre
        $categories = Category::whereHas('products', function($query) use ($artisan) {
            $query->where('artisan_id', $artisan->id)
                  ->where('is_published', true);
        })->orderBy('name')->get();

        return view('front.artisans.show', compact('artisan', 'products', 'categories'));
    }

    public function index()
    {
        $artisans = Artisan::where('is_approved', true)
            ->withCount(['products' => function($query) {
                $query->where('is_published', true);
            }])
            ->orderBy('shop_name')
            ->paginate(12);

        // Statistiques globales
        $totalArtisans = Artisan::where('is_approved', true)->count();
        $totalProducts = \App\Models\Product::where('is_published', true)
            ->whereHas('artisan', function($query) {
                $query->where('is_approved', true);
            })
            ->count();

        return view('front.artisans.index', compact('artisans', 'totalArtisans', 'totalProducts'));
    }
}