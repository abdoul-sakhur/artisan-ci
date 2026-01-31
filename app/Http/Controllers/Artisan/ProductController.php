<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artisan = Auth::user()->artisan;
        
        $query = $artisan->products()->with(['category', 'images']);

        // Filtres
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'low_stock') {
                $query->where('quantity', '<', 10);
            } elseif ($request->status === 'out_of_stock') {
                $query->where('quantity', 0);
            }
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $status = $request->get('status', 'all');

        return view('artisan.products.index', compact('products', 'categories', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('artisan.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $artisan = Auth::user()->artisan;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['artisan_id'] = $artisan->id;
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        $product = Product::create($validated);

        return redirect()->route('artisan.products.index')
            ->with('success', 'Produit créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorizeProduct($product);
        
        $product->load(['category', 'images', 'orderItems.order']);
        
        return view('artisan.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        
        $categories = Category::where('is_active', true)->get();
        return view('artisan.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        return redirect()->route('artisan.products.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        
        $product->delete();

        return redirect()->route('artisan.products.index')
            ->with('success', 'Produit supprimé avec succès !');
    }

    /**
     * Authorize product ownership
     */
    private function authorizeProduct(Product $product)
    {
        $artisan = Auth::user()->artisan;
        
        if ($product->artisan_id !== $artisan->id) {
            abort(403, 'Accès non autorisé.');
        }
    }
}
