<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getItems();
        $total = $this->cartService->getTotal();
        $count = $this->cartService->getCount();

        return view('front.cart.index', compact('cartItems', 'total', 'count'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);

        // Vérifier le stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant. Stock disponible: ' . $product->stock_quantity
            ], 400);
        }

        $this->cartService->add($product, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'cart' => [
                'count' => $this->cartService->getCount(),
                'total' => $this->cartService->getFormattedTotal(),
                'items' => $this->cartService->getItems()
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides'
            ], 422);
        }

        $product = Product::find($request->product_id);

        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant'
            ], 400);
        }

        $this->cartService->update($request->product_id, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Panier mis à jour',
            'cart' => [
                'count' => $this->cartService->getCount(),
                'total' => $this->cartService->getFormattedTotal(),
                'items' => $this->cartService->getItems()
            ]
        ]);
    }

    public function remove(Request $request)
    {
        $this->cartService->remove($request->product_id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit retiré du panier',
                'cart' => [
                    'count' => $this->cartService->getCount(),
                    'total' => $this->cartService->getFormattedTotal(),
                    'items' => $this->cartService->getItems()
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Produit retiré du panier');
    }

    public function clear()
    {
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'message' => 'Panier vidé'
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => $this->cartService->getCount()
        ]);
    }
}