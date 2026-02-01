<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'shop_logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'shop_banner' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:8192',
        ]);

        // Générer un slug unique
        $validated['shop_slug'] = Str::slug($validated['shop_name']) . '-' . Str::random(6);
        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = false; // Par défaut, en attente d'approbation

        // Handle initial logo upload
        if ($request->hasFile('shop_logo')) {
            $path = $request->file('shop_logo')->store('artisans/logos', 'public');
            $validated['shop_logo'] = $path;
        }

        // Handle initial banner upload
        if ($request->hasFile('shop_banner')) {
            $path = $request->file('shop_banner')->store('artisans/banners', 'public');
            $validated['shop_banner'] = $path;
        }

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
            'shop_logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'shop_banner' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:8192',
        ]);

        // Mettre à jour le slug si le nom change
        if ($validated['shop_name'] !== $artisan->shop_name) {
            $validated['shop_slug'] = Str::slug($validated['shop_name']) . '-' . Str::random(6);
        }

        // Handle logo replacement
        if ($request->hasFile('shop_logo')) {
            if (!empty($artisan->shop_logo)) {
                Storage::disk('public')->delete($artisan->shop_logo);
            }
            $path = $request->file('shop_logo')->store('artisans/logos', 'public');
            $validated['shop_logo'] = $path;
        }

        // Handle banner replacement
        if ($request->hasFile('shop_banner')) {
            if (!empty($artisan->shop_banner)) {
                Storage::disk('public')->delete($artisan->shop_banner);
            }
            $path = $request->file('shop_banner')->store('artisans/banners', 'public');
            $validated['shop_banner'] = $path;
        }

        $artisan->update($validated);

        return redirect()->route('artisan.profile.edit')
            ->with('success', 'Profil de la boutique mis à jour avec succès !');
    }
}
