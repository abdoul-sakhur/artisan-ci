<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Artisan;
use App\Models\Product;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    /**
     * Statistiques calculées
     */
    public $totalArtisans;
    public $pendingArtisans;
    public $totalClients;
    public $totalProducts;
    public $publishedProducts;
    public $totalOrders;
    public $pendingOrders;
    public $totalRevenue;
    public $recentOrders;
    public $topProducts;

    /**
     * Période sélectionnée pour les stats
     */
    public $period = '7days'; // 7days, 30days, all

    /**
     * Mount - Initialisation du composant
     */
    public function mount()
    {
        $this->loadStatistics();
    }

    /**
     * Charger toutes les statistiques
     */
    public function loadStatistics()
    {
        // Statistiques des artisans
        $this->totalArtisans = Artisan::count();
        $this->pendingArtisans = Artisan::where('is_approved', false)->count();

        // Statistiques des clients
        $this->totalClients = User::role('client')->count();

        // Statistiques des produits
        $this->totalProducts = Product::count();
        $this->publishedProducts = Product::where('is_published', true)->count();

        // Statistiques des commandes
        $query = Order::query();
        
        if ($this->period === '7days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($this->period === '30days') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $this->totalOrders = $query->count();
        $this->pendingOrders = (clone $query)->where('status', Order::STATUS_PENDING)->count();
        $this->totalRevenue = (clone $query)->sum('total_amount');

        // Commandes récentes
        $this->recentOrders = Order::with(['user', 'artisan'])
            ->latest()
            ->take(5)
            ->get();

        // Produits les plus vus
        $this->topProducts = Product::with(['artisan', 'category'])
            ->where('is_published', true)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Changer la période et recharger les stats
     */
    public function changePeriod($period)
    {
        $this->period = $period;
        $this->loadStatistics();
    }

    /**
     * Render du composant
     */
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
