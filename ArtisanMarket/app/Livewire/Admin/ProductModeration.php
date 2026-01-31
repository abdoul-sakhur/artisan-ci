<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductModeration extends Component
{
    use WithPagination;

    /**
     * Recherche en temps réel
     */
    public $search = '';

    /**
     * Filtre par catégorie
     */
    public $categoryFilter = '';

    /**
     * Filtre par statut
     */
    public $statusFilter = 'all'; // all, published, unpublished, featured

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**
     * Publier un produit
     */
    public function publish($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_published' => true]);
        
        $this->dispatch('notify', 'Produit publié avec succès !');
    }

    /**
     * Masquer un produit
     */
    public function unpublish($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_published' => false]);
        
        $this->dispatch('notify', 'Produit masqué.');
    }

    /**
     * Mettre en vedette
     */
    public function toggleFeatured($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_featured' => !$product->is_featured]);
        
        $message = $product->is_featured ? 'Produit mis en vedette !' : 'Produit retiré de la vedette.';
        $this->dispatch('notify', $message);
    }

    /**
     * Supprimer un produit (soft delete)
     */
    public function delete($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
        
        $this->dispatch('notify', 'Produit supprimé.');
    }

    /**
     * Render du composant
     */
    public function render()
    {
        $query = Product::with(['artisan.user', 'category', 'primaryImage']);

        // Filtre par statut
        if ($this->statusFilter === 'published') {
            $query->where('is_published', true);
        } elseif ($this->statusFilter === 'unpublished') {
            $query->where('is_published', false);
        } elseif ($this->statusFilter === 'featured') {
            $query->where('is_featured', true);
        }

        // Filtre par catégorie
        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('artisan', function ($artisanQuery) {
                      $artisanQuery->where('shop_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::active()->orderBy('name')->get();

        return view('livewire.admin.product-moderation', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
