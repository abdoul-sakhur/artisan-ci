<?php

namespace App\Livewire\Artisan;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class OrderList extends Component
{
    use WithPagination;

    /**
     * Filtres
     */
    public $filterStatus = 'all'; // all, pending, processing, shipped, delivered
    public $search = '';

    /**
     * Modal de détails
     */
    public $selectedOrder = null;
    public $showDetailsModal = false;

    /**
     * Reset pagination on filter change
     */
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Afficher les détails d'une commande
     */
    public function showOrderDetails($orderId)
    {
        $this->selectedOrder = Order::with(['user', 'items.product.primaryImage'])
            ->findOrFail($orderId);

        // Vérifier que cette commande contient au moins un produit de cet artisan
        $artisanId = Auth::user()->artisan->id;
        $hasArtisanProduct = $this->selectedOrder->items->contains(function ($item) use ($artisanId) {
            return $item->product->artisan_id === $artisanId;
        });

        if (!$hasArtisanProduct) {
            $this->dispatch('notify', ['message' => 'Commande non trouvée.', 'type' => 'error']);
            return;
        }

        $this->showDetailsModal = true;
    }

    /**
     * Fermer le modal
     */
    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedOrder = null;
    }

    /**
     * Changer le statut d'une commande
     */
    public function updateOrderStatus($orderId, $newStatus)
    {
        $order = Order::findOrFail($orderId);

        // Vérifier que cette commande contient au moins un produit de cet artisan
        $artisanId = Auth::user()->artisan->id;
        $hasArtisanProduct = $order->items->contains(function ($item) use ($artisanId) {
            return $item->product->artisan_id === $artisanId;
        });

        if (!$hasArtisanProduct) {
            $this->dispatch('notify', ['message' => 'Commande non trouvée.', 'type' => 'error']);
            return;
        }

        $validStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        
        if (!in_array($newStatus, $validStatuses)) {
            $this->dispatch('notify', ['message' => 'Statut invalide.', 'type' => 'error']);
            return;
        }

        $order->update(['status' => $newStatus]);

        $this->dispatch('notify', ['message' => 'Statut mis à jour avec succès !', 'type' => 'success']);

        // Rafraîchir les détails si modal ouvert
        if ($this->showDetailsModal && $this->selectedOrder->id === $orderId) {
            $this->selectedOrder = Order::with(['user', 'items.product.primaryImage'])->find($orderId);
        }
    }

    /**
     * Render
     */
    public function render()
    {
        $artisan = Auth::user()->artisan;

        if (!$artisan) {
            return redirect()->route('artisan.shop.setup');
        }

        // Récupérer toutes les commandes contenant au moins un produit de cet artisan
        $query = Order::with(['user', 'items.product.primaryImage'])
            ->whereHas('items.product', function ($q) use ($artisan) {
                $q->where('artisan_id', $artisan->id);
            });

        // Filtre par statut
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Recherche par référence ou nom client
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('livewire.artisan.order-list', [
            'orders' => $orders,
        ]);
    }
}
