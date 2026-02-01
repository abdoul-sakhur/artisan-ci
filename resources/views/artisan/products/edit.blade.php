<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Modifier le produit') }} : {{ $product->name }}
            </h2>
            <x-ui.button variant="outline" href="{{ route('artisan.products.index') }}">
                Retour
            </x-ui.button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if($errors->any())
                <x-ui.alert variant="destructive" dismissible class="mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-ui.alert>
            @endif

            <x-ui.card>
                <form method="POST" action="{{ route('artisan.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-ui.label for="name" required>Nom du produit</x-ui.label>
                        <x-ui.input 
                            id="name" 
                            name="name" 
                            type="text" 
                            :value="old('name', $product->name)" 
                            required 
                            autofocus
                        />
                    </div>

                    <div>
                        <x-ui.label for="category_id" required>Catégorie</x-ui.label>
                        <x-ui.select id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-ui.select>
                    </div>

                    <div>
                        <x-ui.label for="description" required>Description</x-ui.label>
                        <x-ui.textarea 
                            id="description" 
                            name="description" 
                            rows="6"
                            required
                        >{{ old('description', $product->description) }}</x-ui.textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-ui.label for="price" required>Prix (FCFA)</x-ui.label>
                            <x-ui.input 
                                id="price" 
                                name="price" 
                                type="number" 
                                :value="old('price', $product->price)" 
                                required
                                min="0"
                                step="0.01"
                            />
                        </div>

                        <div>
                            <x-ui.label for="quantity" required>Quantité en stock</x-ui.label>
                            <x-ui.input 
                                id="quantity" 
                                name="quantity" 
                                type="number" 
                                :value="old('quantity', $product->quantity)" 
                                required
                                min="0"
                            />
                        </div>
                    </div>

                    <div>
                        <x-ui.label for="sku">SKU (optionnel)</x-ui.label>
                        <x-ui.input 
                            id="sku" 
                            name="sku" 
                            type="text" 
                            :value="old('sku', $product->sku)"
                        />
                    </div>

                    <!-- Upload d'images -->
                    @php
                        $existingImages = $product->images->map(function($image) {
                            return [
                                'id' => $image->id,
                                'thumbnail_url' => $image->thumbnail_url,
                                'is_primary' => $image->is_primary,
                                'formatted_size' => $image->formatted_size,
                            ];
                        })->toArray();
                    @endphp
                    <x-ui.file-upload 
                        name="images"
                        label="Images du produit"
                        :multiple="true"
                        maxSize="5"
                        :existingImages="$existingImages"
                    />

                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <x-ui.checkbox 
                                id="is_published" 
                                name="is_published" 
                                value="1"
                                :checked="old('is_published', $product->is_published)"
                            />
                            <x-ui.label for="is_published" class="!mb-0">
                                Publier le produit
                            </x-ui.label>
                        </div>

                        <div class="flex items-center gap-2">
                            <x-ui.checkbox 
                                id="is_featured" 
                                name="is_featured" 
                                value="1"
                                :checked="old('is_featured', $product->is_featured)"
                            />
                            <x-ui.label for="is_featured" class="!mb-0">
                                Produit en vedette
                            </x-ui.label>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <x-ui.button type="submit" variant="default" as="button">
                            Enregistrer les modifications
                        </x-ui.button>
                        <x-ui.button type="button" variant="outline" href="{{ route('artisan.products.index') }}">
                            Annuler
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
