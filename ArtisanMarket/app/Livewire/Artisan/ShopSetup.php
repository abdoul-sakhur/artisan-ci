<?php

namespace App\Livewire\Artisan;

use App\Models\Artisan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ShopSetup extends Component
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
     * Validation rules
     */
    protected function rules()
    {
        return [
            'shop_name' => 'required|string|min:3|max:255',
            'shop_description' => 'required|string|min:20|max:1000',
            'shop_logo' => 'nullable|image|max:2048', // 2MB max
            'shop_banner' => 'nullable|image|max:3072', // 3MB max
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    protected $messages = [
        'shop_name.required' => 'Le nom de la boutique est obligatoire.',
        'shop_name.min' => 'Le nom doit contenir au moins 3 caractères.',
        'shop_description.required' => 'La description est obligatoire.',
        'shop_description.min' => 'La description doit contenir au moins 20 caractères.',
        'shop_logo.image' => 'Le logo doit être une image.',
        'shop_logo.max' => 'Le logo ne doit pas dépasser 2 MB.',
        'shop_banner.image' => 'La bannière doit être une image.',
        'shop_banner.max' => 'La bannière ne doit pas dépasser 3 MB.',
    ];

    /**
     * Validation en temps réel
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Créer la boutique
     */
    public function createShop()
    {
        $this->validate();

        $user = Auth::user();

        // Vérifier si l'utilisateur a déjà une boutique
        if ($user->artisan) {
            session()->flash('error', 'Vous avez déjà une boutique.');
            return redirect()->route('artisan.dashboard');
        }

        // Upload du logo
        $logoPath = null;
        if ($this->shop_logo) {
            $logoPath = $this->shop_logo->store('shops/logos', 'public');
        }

        // Upload de la bannière
        $bannerPath = null;
        if ($this->shop_banner) {
            $bannerPath = $this->shop_banner->store('shops/banners', 'public');
        }

        // Créer l'artisan
        Artisan::create([
            'user_id' => $user->id,
            'shop_name' => $this->shop_name,
            'shop_description' => $this->shop_description,
            'shop_logo' => $logoPath,
            'shop_banner' => $bannerPath,
            'is_approved' => false,
        ]);

        session()->flash('success', 'Votre boutique a été créée ! Elle sera examinée par notre équipe dans les prochaines 24h.');
        
        return redirect()->route('artisan.dashboard');
    }

    /**
     * Render
     */
    public function render()
    {
        return view('livewire.artisan.shop-setup');
    }
}
