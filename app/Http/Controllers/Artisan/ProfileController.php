<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $artisan = Auth::user()->artisan;
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
