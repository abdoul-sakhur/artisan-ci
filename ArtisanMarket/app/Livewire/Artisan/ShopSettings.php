<?php

namespace App\Livewire\Artisan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopSettings extends Component
{
    use WithFileUploads;

    /**
     * Champs du formulaire
     */
    public $shop_name;
    public $shop_description;
    public $shop_logo;
    public $shop_banner;

    /**
     * Nouveaux fichiers uploadés
     */
    public $newLogo;
    public $newBanner;

    /**
     * Validation
     */
    protected function rules()
    {
        return [
            'shop_name' => 'required|string|min:3|max:255',
            'shop_description' => 'required|string|min:20',
            'newLogo' => 'nullable|image|max:2048',
            'newBanner' => 'nullable|image|max:3072',
        ];
    }

    protected $messages = [
        'shop_name.required' => 'Le nom de la boutique est obligatoire.',
        'shop_name.min' => 'Le nom doit contenir au moins 3 caractères.',
        'shop_description.required' => 'La description est obligatoire.',
        'shop_description.min' => 'La description doit contenir au moins 20 caractères.',
        'newLogo.image' => 'Le logo doit être une image.',
        'newLogo.max' => 'Le logo ne doit pas dépasser 2 MB.',
        'newBanner.image' => 'La bannière doit être une image.',
        'newBanner.max' => 'La bannière ne doit pas dépasser 3 MB.',
    ];

    /**
     * Mount - Charger les données actuelles
     */
    public function mount()
    {
        $artisan = Auth::user()->artisan;

        if (!$artisan) {
            return redirect()->route('artisan.shop.setup');
        }

        $this->shop_name = $artisan->shop_name;
        $this->shop_description = $artisan->shop_description;
        $this->shop_logo = $artisan->shop_logo;
        $this->shop_banner = $artisan->shop_banner;
    }

    /**
     * Validation en temps réel
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Mettre à jour les paramètres de la boutique
     */
    public function updateSettings()
    {
        $artisan = Auth::user()->artisan;

        if (!$artisan) {
            return redirect()->route('artisan.shop.setup');
        }

        $this->validate();

        $data = [
            'shop_name' => $this->shop_name,
            'shop_description' => $this->shop_description,
        ];

        // Upload du nouveau logo
        if ($this->newLogo) {
            // Supprimer l'ancien logo si existant
            if ($artisan->shop_logo) {
                Storage::disk('public')->delete($artisan->shop_logo);
            }

            $logoPath = $this->newLogo->store('shops/logos', 'public');
            $data['shop_logo'] = $logoPath;
            $this->shop_logo = $logoPath;
            $this->newLogo = null;
        }

        // Upload de la nouvelle bannière
        if ($this->newBanner) {
            // Supprimer l'ancienne bannière si existante
            if ($artisan->shop_banner) {
                Storage::disk('public')->delete($artisan->shop_banner);
            }

            $bannerPath = $this->newBanner->store('shops/banners', 'public');
            $data['shop_banner'] = $bannerPath;
            $this->shop_banner = $bannerPath;
            $this->newBanner = null;
        }

        $artisan->update($data);

        $this->dispatch('notify', ['message' => 'Paramètres mis à jour avec succès !', 'type' => 'success']);
    }

    /**
     * Render
     */
    public function render()
    {
        return view('livewire.artisan.shop-settings');
    }
}
