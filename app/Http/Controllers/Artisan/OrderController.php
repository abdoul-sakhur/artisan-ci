<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $artisan = Auth::user()->artisan;
        
        $query = $artisan->orders()->with('user');

        // Filtrer par statut
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);
        $status = $request->get('status', 'all');

        return view('artisan.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $artisan = Auth::user()->artisan;
        
        if ($order->artisan_id !== $artisan->id) {
            abort(403, 'Accès non autorisé.');
        }

        $order->load(['user', 'orderItems.product']);
        
        return view('artisan.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $artisan = Auth::user()->artisan;
        
        if ($order->artisan_id !== $artisan->id) {
            abort(403, 'Accès non autorisé.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('artisan.orders.show', $order)
            ->with('success', 'Statut de la commande mis à jour !');
    }
}
