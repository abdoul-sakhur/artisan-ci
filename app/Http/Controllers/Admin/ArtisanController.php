<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 

class ArtisanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Artisan::with('user');
        
        if ($status === 'pending') {
            $query->pending();
        } elseif ($status === 'approved') {
            $query->approved();
        }
        
        $artisans = $query->latest()->paginate(15);
        
        return view('admin.artisans.index', compact('artisans', 'status'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Artisan $artisan)
    {
        $artisan->load(['user', 'products', 'orders']);
        
        return view('admin.artisans.show', compact('artisan'));
    }

    /**
     * Approve an artisan.
     */
    public function approve(Artisan $artisan)
    {
        $artisan->approve(Auth::user());
        
        return redirect()
            ->route('admin.artisans.index')
            ->with('success', "L'artisan {$artisan->shop_name} a été approuvé avec succès.");
    }

    /**
     * Reject an artisan.
     */
    public function reject(Artisan $artisan)
    {
        $shopName = $artisan->shop_name;
        $user = $artisan->user;
        
        // Supprimer l'artisan
        $artisan->delete();
        
        // Optionnel: Supprimer aussi l'utilisateur associé
        // $user->delete();
        
        return redirect()
            ->route('admin.artisans.index')
            ->with('success', "L'artisan {$shopName} a été rejeté et supprimé.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artisan $artisan)
    {
        $shopName = $artisan->shop_name;
        $artisan->delete();
        
        return redirect()
            ->route('admin.artisans.index')
            ->with('success', "L'artisan {$shopName} a été supprimé.");
    }
}
