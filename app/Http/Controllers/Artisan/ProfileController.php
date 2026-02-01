<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function create()
    {
        // Si l'artisan existe déjà, rediriger
        if (Auth::user()->artisan) {
            return redirect()->route('artisan.profile.edit');
        }
        
        return view('artisan.profile.create');
    }

    public function store(Request $request)
    {
        // Vérifier que l'artisan n'existe pas déjà
        if (Auth::user()->artisan) {
            return redirect()->route('artisan.profile.edit')
                ->with('info', 'Votre profil artisan existe déjà.');
        }

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string',
            'shop_logo' => 'nullable|url',
            'shop_banner' => 'nullable|url',
        ]);

        // Générer un slug unique
        $validated['shop_slug'] = Str::slug($validated['shop_name']) . '-' . Str::random(6);
        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = false; // Par défaut, en attente d'approbation

        Auth::user()->artisan()->create($validated);

        return redirect()->route('artisan.dashboard.pending')
            ->with('success', 'Votre boutique a été créée avec succès ! Elle est en attente d\'approbation.');
    }

    public function edit()
    {
        $artisan = Auth::user()->artisan;
        
        // Si l'artisan n'existe pas, rediriger vers la création
        if (!$artisan) {
            return redirect()->route('artisan.profile.create');
        }
        
        return view('artisan.profile.edit', compact('artisan'));
    }

    public function update(Request $request)
    {
        $artisan = Auth::user()->artisan;

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string',
            'shop_logo' => 'nullable|url',
            'shop_banner' => 'nullable|url',
        ]);

        // Mettre à jour le slug si le nom change
        if ($validated['shop_name'] !== $artisan->shop_name) {
            $validated['shop_slug'] = Str::slug($validated['shop_name']) . '-' . Str::random(6);
        }

        $artisan->update($validated);

        return redirect()->route('artisan.profile.edit')
            ->with('success', 'Profil de la boutique mis à jour avec succès !');
    }
}
