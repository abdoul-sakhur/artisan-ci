<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth');
    }

    public function index()
    {
        // Vérifier que le panier n'est pas vide
        if ($this->cartService->getCount() === 0) {
            return redirect()->route('front.cart.index')
                ->with('error', 'Votre panier est vide');
        }

        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->getTotal();

        return view('front.checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        // Vérifier que le panier n'est pas vide
        if ($this->cartService->getCount() === 0) {
            return redirect()->route('front.cart.index')
                ->with('error', 'Votre panier est vide');
        }

        $request->validate([
            'delivery_address' => 'required|array',
            'delivery_address.first_name' => 'required|string|max:255',
            'delivery_address.last_name' => 'required|string|max:255',
            'delivery_address.address' => 'required|string|max:255',
            'delivery_address.city' => 'required|string|max:255',
            'delivery_address.postal_code' => 'required|string|max:10',
            'delivery_address.country' => 'required|string|max:255',
            'delivery_address.phone' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            // Créer la commande
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total_amount' => $this->cartService->getTotal(),
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
                'created_at' => now(),
            ]);

            // Créer les items de commande
            foreach ($this->cartService->getItems() as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['product']->price,
                    'total' => $item['product']->price * $item['quantity'],
                ]);

                // Décrémenter le stock
                $item['product']->decrement('stock_quantity', $item['quantity']);
            }

            // Vider le panier
            $this->cartService->clear();

            DB::commit();

            return redirect()->route('front.orders.confirmation', $order->order_number)
                ->with('success', 'Votre commande a été confirmée !');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de votre commande');
        }
    }

    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'CMD-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}