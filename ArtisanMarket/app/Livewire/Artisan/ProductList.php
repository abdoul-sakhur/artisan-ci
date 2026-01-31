<?php

namespace App\Livewire\Artisan;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ProductList extends Component
{
    use WithPagination;

    /**
     * Recherche et filtres
     */
    public $search = '';
    public $filterStatus = 'all'; // all, published, unpublished

    /**
     * Reset pagination on search
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    /**
     * Publier/Dépublier un produit
     */
    public function togglePublish($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Vérifier que le produit appartient à cet artisan
        if ($product->artisan_id !== Auth::user()->artisan->id) {
            $this->dispatch('notify', ['message' => 'Produit non trouvé.', 'type' => 'error']);
            return;
        }

        $product->update(['is_published' => !$product->is_published]);
        
        $message = $product->is_published 
            ? 'Produit publié avec succès !' 
            : 'Produit dépublié.';
        
        $this->dispatch('notify', ['message' => $message, 'type' => 'success']);
    }

    /**
     * Supprimer un produit (soft delete)
     */
    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Vérifier que le produit appartient à cet artisan
        if ($product->artisan_id !== Auth::user()->artisan->id) {
            $this->dispatch('notify', ['message' => 'Produit non trouvé.', 'type' => 'error']);
            return;
        }

        $product->delete();
        
        $this->dispatch('notify', ['message' => 'Produit supprimé.', 'type' => 'success']);
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

        $query = $artisan->products()->with(['category', 'primaryImage']);

        // Filtre par statut
        if ($this->filterStatus === 'published') {
            $query->where('is_published', true);
        } elseif ($this->filterStatus === 'unpublished') {
            $query->where('is_published', false);
        }

        // Recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $products = $query->latest()->paginate(12);

        return view('livewire.artisan.product-list', [
            'products' => $products,
        ]);
    }
}
