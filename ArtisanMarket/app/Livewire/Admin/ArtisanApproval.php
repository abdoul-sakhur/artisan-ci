<?php

namespace App\Livewire\Admin;

use App\Models\Artisan;
use Livewire\Component;
use Livewire\WithPagination;

class ArtisanApproval extends Component
{
    use WithPagination;

    /**
     * Recherche en temps réel
     */
    public $search = '';

    /**
     * Filtre par statut
     */
    public $filterStatus = 'pending'; // pending, approved, all

    /**
     * Reset pagination when search changes
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Approuver un artisan
     */
    public function approve($artisanId)
    {
        $artisan = Artisan::findOrFail($artisanId);
        
        $artisan->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        // Notification de succès
        $this->dispatch('notify', 'Artisan approuvé avec succès !');
        
        // Optionnel : Envoyer un email à l'artisan
        // Mail::to($artisan->user->email)->send(new ArtisanApprovedMail($artisan));
    }

    /**
     * Rejeter un artisan
     */
    public function reject($artisanId)
    {
        $artisan = Artisan::findOrFail($artisanId);
        
        // Pour l'instant, on supprime simplement
        // Dans une vraie application, vous pourriez :
        // - Ajouter un champ "rejected_at" ou "status" avec enum
        // - Envoyer un email de rejet avec raison
        $artisan->delete();

        $this->dispatch('notify', 'Artisan rejeté.');
    }

    /**
     * Render du composant
     */
    public function render()
    {
        $query = Artisan::with('user');

        // Filtre par statut
        if ($this->filterStatus === 'pending') {
            $query->where('is_approved', false);
        } elseif ($this->filterStatus === 'approved') {
            $query->where('is_approved', true);
        }

        // Recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('shop_name', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $artisans = $query->latest()->paginate(10);

        return view('livewire.admin.artisan-approval', [
            'artisans' => $artisans,
        ]);
    }
}
