<?php

namespace App\Livewire\Artisan;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductForm extends Component
{
    use WithFileUploads;

    /**
     * Champs du formulaire
     */
    public $productId = null;
    public $name;
    public $description;
    public $price;
    public $quantity_available = 0;
    public $category_id;
    public $is_published = false;

    /**
     * Images
     */
    public $newImages = []; // Nouvelles images à uploader
    public $existingImages = []; // Images existantes (mode édition)
    public $imagesToDelete = []; // IDs des images à supprimer

    /**
     * Mode édition
     */
    public $isEditMode = false;

    /**
     * Validation
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:20',
            'price' => 'required|numeric|min:0.01',
            'quantity_available' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'newImages.*' => 'nullable|image|max:2048', // Max 2MB par image
        ];
    }

    protected $messages = [
        'name.required' => 'Le nom du produit est obligatoire.',
        'name.min' => 'Le nom doit contenir au moins 3 caractères.',
        'description.required' => 'La description est obligatoire.',
        'description.min' => 'La description doit contenir au moins 20 caractères.',
        'price.required' => 'Le prix est obligatoire.',
        'price.min' => 'Le prix doit être supérieur à 0.',
        'quantity_available.required' => 'La quantité est obligatoire.',
        'quantity_available.min' => 'La quantité ne peut pas être négative.',
        'category_id.required' => 'Veuillez sélectionner une catégorie.',
        'category_id.exists' => 'Catégorie invalide.',
        'newImages.*.image' => 'Le fichier doit être une image.',
        'newImages.*.max' => 'Chaque image ne doit pas dépasser 2 MB.',
    ];

    /**
     * Mount pour édition
     */
    public function mount($productId = null)
    {
        if ($productId) {
            $this->isEditMode = true;
            $this->productId = $productId;
            $this->loadProduct();
        }
    }

    /**
     * Charger un produit existant
     */
    private function loadProduct()
    {
        $product = Product::with('images')->findOrFail($this->productId);

        // Vérifier que le produit appartient à cet artisan
        if ($product->artisan_id !== Auth::user()->artisan->id) {
            abort(403);
        }

        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->quantity_available = $product->quantity_available;
        $this->category_id = $product->category_id;
        $this->is_published = $product->is_published;
        $this->existingImages = $product->images->toArray();
    }

    /**
     * Validation en temps réel
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Marquer une image existante pour suppression
     */
    public function markImageForDeletion($imageId)
    {
        if (!in_array($imageId, $this->imagesToDelete)) {
            $this->imagesToDelete[] = $imageId;
        }
    }

    /**
     * Annuler la suppression d'une image
     */
    public function unmarkImageForDeletion($imageId)
    {
        $this->imagesToDelete = array_diff($this->imagesToDelete, [$imageId]);
    }

    /**
     * Retirer une nouvelle image avant upload
     */
    public function removeNewImage($index)
    {
        array_splice($this->newImages, $index, 1);
    }

    /**
     * Créer ou mettre à jour le produit
     */
    public function saveProduct()
    {
        $artisan = Auth::user()->artisan;

        if (!$artisan) {
            return redirect()->route('artisan.shop.setup');
        }

        $this->validate();

        // Validation du nombre total d'images (max 5)
        $totalImages = count($this->existingImages) - count($this->imagesToDelete) + count($this->newImages);
        
        if ($totalImages > 5) {
            $this->addError('newImages', 'Vous ne pouvez avoir que 5 images maximum par produit.');
            return;
        }

        if ($totalImages === 0 && !$this->isEditMode) {
            $this->addError('newImages', 'Veuillez ajouter au moins une image.');
            return;
        }

        DB::transaction(function () use ($artisan) {
            // Créer ou mettre à jour le produit
            if ($this->isEditMode) {
                $product = Product::findOrFail($this->productId);
                $product->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'price' => $this->price,
                    'quantity_available' => $this->quantity_available,
                    'category_id' => $this->category_id,
                    'is_published' => $this->is_published,
                ]);
            } else {
                $product = Product::create([
                    'artisan_id' => $artisan->id,
                    'category_id' => $this->category_id,
                    'name' => $this->name,
                    'description' => $this->description,
                    'price' => $this->price,
                    'quantity_available' => $this->quantity_available,
                    'is_published' => $this->is_published,
                ]);
            }

            // Supprimer les images marquées pour suppression
            if (!empty($this->imagesToDelete)) {
                foreach ($this->imagesToDelete as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image && $image->product_id === $product->id) {
                        Storage::disk('public')->delete($image->image_url);
                        $image->delete();
                    }
                }
            }

            // Uploader les nouvelles images
            if (!empty($this->newImages)) {
                $currentMaxOrder = $product->images()->max('sort_order') ?? 0;

                foreach ($this->newImages as $index => $image) {
                    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('products', $filename, 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                        'sort_order' => $currentMaxOrder + $index + 1,
                        'is_primary' => $product->images()->count() === 0 && $index === 0,
                    ]);
                }
            }
        });

        session()->flash('success', $this->isEditMode ? 'Produit modifié avec succès !' : 'Produit créé avec succès !');
        
        return redirect()->route('artisan.products.index');
    }

    /**
     * Render
     */
    public function render()
    {
        $categories = Category::orderBy('name')->get();

        return view('livewire.artisan.product-form', [
            'categories' => $categories,
        ]);
    }
}
