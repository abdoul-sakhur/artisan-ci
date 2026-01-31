<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_users' => User::count(),
            'total_artisans' => Artisan::count(),
            'pending_artisans' => Artisan::pending()->count(),
            'approved_artisans' => Artisan::approved()->count(),
            'total_products' => Product::count(),
            'published_products' => Product::published()->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::whereIn('status', ['delivered', 'shipped'])->sum('total_amount'),
            'pending_orders' => Order::pending()->count(),
        ];

        // Artisans en attente de validation (5 derniers)
        $pendingArtisans = Artisan::with('user')
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        // Dernières commandes (10 dernières)
        $recentOrders = Order::with(['user', 'artisan.user'])
            ->latest()
            ->take(10)
            ->get();

        // Top 5 artisans par ventes
        $topArtisans = Artisan::with('user')
            ->withCount('orders')
            ->having('orders_count', '>', 0)
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Statistiques mensuelles (6 derniers mois)
        $monthlyStats = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as orders_count'),
            DB::raw('SUM(total_amount) as revenue')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'pendingArtisans',
            'recentOrders',
            'topArtisans',
            'monthlyStats'
        ));
    }
}

