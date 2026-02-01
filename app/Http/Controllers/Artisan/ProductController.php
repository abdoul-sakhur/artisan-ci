<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        
        if (!$artisan) {
            return redirect()->route('artisan.profile.create')
                ->with('info', 'Veuillez d\'abord créer votre profil artisan.');
        }
        
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
    public function store(Request $request, ImageService $imageService)
    {
        $artisan = Auth::user()->artisan;
        
        if (!$artisan) {
            return redirect()->route('artisan.profile.create')
                ->with('info', 'Veuillez d\'abord créer votre profil artisan.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB max
        ]);

        $validated['artisan_id'] = $artisan->id;
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        DB::beginTransaction();
        try {
            $product = Product::create($validated);

            // Upload des images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $imageData = $imageService->uploadImage($image, 'products', [
                        'max_width' => 1200,
                        'max_height' => 1200,
                        'thumb_width' => 400,
                        'thumb_height' => 400,
                    ]);

                    $product->images()->create([
                        'path' => $imageData['path'],
                        'thumbnail_path' => $imageData['thumbnail_path'],
                        'file_size' => $imageData['file_size'],
                        'mime_type' => $imageData['mime_type'],
                        'is_primary' => $index === 0, // Première image = primaire
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('artisan.products.index')
                ->with('success', 'Produit créé avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Erreur lors de la création du produit : ' . $e->getMessage());
        }
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
    public function update(Request $request, Product $product, ImageService $imageService)
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
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['is_featured'] = $request->has('is_featured');

        DB::beginTransaction();
        try {
            $product->update($validated);

            // Supprimer les images sélectionnées
            if ($request->filled('delete_images')) {
                $imagesToDelete = $product->images()->whereIn('id', $request->delete_images)->get();
                foreach ($imagesToDelete as $image) {
                    $imageService->deleteImage($image->path, $image->thumbnail_path);
                    $image->delete();
                }
            }

            // Upload de nouvelles images
            if ($request->hasFile('images')) {
                $existingImagesCount = $product->images()->count();
                
                foreach ($request->file('images') as $index => $image) {
                    $imageData = $imageService->uploadImage($image, 'products', [
                        'max_width' => 1200,
                        'max_height' => 1200,
                        'thumb_width' => 400,
                        'thumb_height' => 400,
                    ]);

                    $product->images()->create([
                        'path' => $imageData['path'],
                        'thumbnail_path' => $imageData['thumbnail_path'],
                        'file_size' => $imageData['file_size'],
                        'mime_type' => $imageData['mime_type'],
                        'is_primary' => $existingImagesCount === 0 && $index === 0,
                        'sort_order' => $existingImagesCount + $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('artisan.products.index')
                ->with('success', 'Produit mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ImageService $imageService)
    {
        $this->authorizeProduct($product);
        
        DB::beginTransaction();
        try {
            // Supprimer toutes les images du produit
            foreach ($product->images as $image) {
                $imageService->deleteImage($image->path, $image->thumbnail_path);
            }
            
            $product->delete();
            
            DB::commit();

            return redirect()->route('artisan.products.index')
                ->with('success', 'Produit supprimé avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Authorize product ownership
     */
    private function authorizeProduct(Product $product)
    {
        $artisan = Auth::user()->artisan;
        
        if (!$artisan) {
            abort(403, 'Profil artisan non trouvé.');
        }
        
        if ($product->artisan_id !== $artisan->id) {
            abort(403, 'Accès non autorisé.');
        }
    }
}
