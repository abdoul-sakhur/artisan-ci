<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $artisan = Auth::user()->artisan;
        
        if (!$artisan || !$artisan->is_approved) {
            return redirect()->route('artisan.dashboard.pending');
        }

        // Statistiques générales
        $stats = [
            'total_products' => $artisan->products()->count(),
            'published_products' => $artisan->products()->where('is_published', true)->count(),
            'total_orders' => $artisan->orders()->count(),
            'total_revenue' => $artisan->orders()->where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_orders' => $artisan->orders()->where('status', 'pending')->count(),
            'low_stock_products' => $artisan->products()->where('quantity', '<', 10)->count(),
        ];

        // Dernières commandes
        $recentOrders = $artisan->orders()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Produits les plus vendus
        $topProducts = $artisan->products()
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // Produits en rupture de stock
        $outOfStockProducts = $artisan->products()
            ->where('quantity', 0)
            ->orWhere('quantity', '<', 5)
            ->take(5)
            ->get();

        return view('artisan.dashboard', compact(
            'artisan',
            'stats',
            'recentOrders',
            'topProducts',
            'outOfStockProducts'
        ));
    }

    public function pending()
    {
        $artisan = Auth::user()->artisan;
        
        // Si l'artisan n'existe pas encore, rediriger vers la création du profil
        if (!$artisan) {
            return redirect()->route('artisan.profile.create')
                ->with('info', 'Veuillez d\'abord créer votre profil artisan.');
        }
        
        return view('artisan.pending', compact('artisan'));
    }
}
