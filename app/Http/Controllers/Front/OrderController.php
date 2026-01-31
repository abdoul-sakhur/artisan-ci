<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product.images', 'items.product.artisan'])
            ->firstOrFail();

        return view('front.orders.confirmation', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items'])
            ->latest()
            ->paginate(10);

        return view('front.orders.index', compact('orders'));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product.images', 'items.product.artisan'])
            ->firstOrFail();

        return view('front.orders.show', compact('order'));
    }
}