<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nouveau Produit') }}
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
                <form method="POST" action="{{ route('artisan.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-ui.label for="name" required>Nom du produit</x-ui.label>
                        <x-ui.input 
                            id="name" 
                            name="name" 
                            type="text" 
                            :value="old('name')" 
                            required 
                            autofocus
                            placeholder="Ex: Vase en céramique traditionnel"
                        />
                    </div>

                    <div>
                        <x-ui.label for="category_id" required>Catégorie</x-ui.label>
                        <x-ui.select id="category_id" name="category_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            placeholder="Décrivez votre produit en détail..."
                        >{{ old('description') }}</x-ui.textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-ui.label for="price" required>Prix (FCFA)</x-ui.label>
                            <x-ui.input 
                                id="price" 
                                name="price" 
                                type="number" 
                                :value="old('price')" 
                                required
                                min="0"
                                step="0.01"
                                placeholder="5000"
                            />
                        </div>

                        <div>
                            <x-ui.label for="quantity" required>Quantité en stock</x-ui.label>
                            <x-ui.input 
                                id="quantity" 
                                name="quantity" 
                                type="number" 
                                :value="old('quantity', 1)" 
                                required
                                min="0"
                                placeholder="10"
                            />
                        </div>
                    </div>

                    <div>
                        <x-ui.label for="sku">SKU (optionnel)</x-ui.label>
                        <x-ui.input 
                            id="sku" 
                            name="sku" 
                            type="text" 
                            :value="old('sku')"
                            placeholder="PROD-001"
                        />
                        <p class="mt-1 text-sm text-gray-500">Code unique pour identifier le produit</p>
                    </div>

                    <!-- Upload d'images -->
                    <x-ui.file-upload 
                        name="images"
                        label="Images du produit"
                        :multiple="true"
                        maxSize="5"
                    />

                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <x-ui.checkbox 
                                id="is_published" 
                                name="is_published" 
                                value="1"
                                :checked="old('is_published', true)"
                            />
                            <x-ui.label for="is_published" class="!mb-0">
                                Publier immédiatement
                            </x-ui.label>
                        </div>

                        <div class="flex items-center gap-2">
                            <x-ui.checkbox 
                                id="is_featured" 
                                name="is_featured" 
                                value="1"
                                :checked="old('is_featured', false)"
                            />
                            <x-ui.label for="is_featured" class="!mb-0">
                                Produit en vedette
                            </x-ui.label>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <x-ui.button type="submit" variant="default" as="button">
                            Créer le produit
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
