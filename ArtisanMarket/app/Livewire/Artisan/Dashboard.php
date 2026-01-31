<?php

namespace App\Livewire\Artisan;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    /**
     * Statistiques
     */
    public $totalProducts;
    public $publishedProducts;
    public $totalOrders;
    public $pendingOrders;
    public $totalRevenue;
    public $totalViews;
    public $recentOrders;
    public $topProducts;

    /**
     * Mount
     */
    public function mount()
    {
        $artisan = Auth::user()->artisan;

        if (!$artisan) {
            return redirect()->route('artisan.shop.setup');
        }

        $this->loadStatistics($artisan);
    }

    /**
     * Charger les statistiques
     */
    public function loadStatistics($artisan)
    {
        // Statistiques produits
        $this->totalProducts = $artisan->products()->count();
        $this->publishedProducts = $artisan->products()->where('is_published', true)->count();

        // Statistiques commandes
        $this->totalOrders = $artisan->orders()->count();
        $this->pendingOrders = $artisan->orders()->where('status', 'pending')->count();
        $this->totalRevenue = $artisan->orders()->sum('total_amount');

        // Total des vues
        $this->totalViews = $artisan->products()->sum('views_count');

        // Commandes récentes
        $this->recentOrders = $artisan->orders()
            ->with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Top produits
        $this->topProducts = $artisan->products()
            ->with('category')
            ->where('is_published', true)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Render
     */
    public function render()
    {
        return view('livewire.artisan.dashboard');
    }
}
