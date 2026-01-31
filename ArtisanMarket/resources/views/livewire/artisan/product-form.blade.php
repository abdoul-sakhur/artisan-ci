<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $isEditMode ? 'Modifier le produit' : 'Ajouter un produit' }}</h1>
        <p class="text-gray-600 mt-1">{{ $isEditMode ? 'Modifiez les informations de votre produit' : 'Créez un nouveau produit pour votre boutique' }}</p>
    </div>

    <form wire:submit.prevent="saveProduct" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulaire principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Informations générales</h2>

                    <!-- Nom du produit -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom du produit <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            wire:model.blur="name"
                            class="w-full px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Ex: Vase en céramique artisanale"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            wire:model.blur="description"
                            rows="6"
                            class="w-full px-4 py-3 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                            placeholder="Décrivez votre produit en détail..."
                        ></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix et Quantité -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                Prix (DH) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="price" 
                                wire:model.blur="price"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-3 border @error('price') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="0.00"
                            >
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="quantity_available" class="block text-sm font-semibold text-gray-700 mb-2">
                                Quantité <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="quantity_available" 
                                wire:model.blur="quantity_available"
                                min="0"
                                class="w-full px-4 py-3 border @error('quantity_available') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                placeholder="0"
                            >
                            @error('quantity_available')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div class="mt-4">
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Catégorie <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="category_id" 
                            wire:model.blur="category_id"
                            class="w-full px-4 py-3 border @error('category_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Images du produit -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Images (max 5)</h2>

                    <!-- Images existantes (mode édition) -->
                    @if($isEditMode && count($existingImages) > 0)
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Images actuelles</h3>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
                                @foreach($existingImages as $image)
                                    @if(!in_array($image['id'], $imagesToDelete))
                                        <div class="relative group">
                                            <img src="{{ Storage::url($image['image_url']) }}" alt="Image" class="w-full h-24 object-cover rounded-lg border-2 border-gray-300">
                                            @if($image['is_primary'])
                                                <span class="absolute top-1 left-1 px-2 py-1 bg-purple-600 text-white text-xs font-bold rounded">Principale</span>
                                            @endif
                                            <button 
                                                type="button" 
                                                wire:click="markImageForDeletion({{ $image['id'] }})"
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Images marquées pour suppression -->
                            @if(count($imagesToDelete) > 0)
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-sm text-red-800 font-medium">{{ count($imagesToDelete) }} image(s) seront supprimées lors de la sauvegarde</p>
                                    <button 
                                        type="button" 
                                        wire:click="imagesToDelete = []"
                                        class="mt-2 text-xs text-red-600 hover:text-red-800 underline"
                                    >
                                        Annuler les suppressions
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Zone d'upload -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ $isEditMode ? 'Ajouter de nouvelles images' : 'Ajouter des images' }}</h3>
                        
                        <!-- Aperçu des nouvelles images -->
                        @if(count($newImages) > 0)
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4 mb-4">
                                @foreach($newImages as $index => $image)
                                    <div class="relative group">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Aperçu" class="w-full h-24 object-cover rounded-lg border-2 border-purple-300">
                                        <button 
                                            type="button" 
                                            wire:click="removeNewImage({{ $index }})"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Input file -->
                        <label class="block cursor-pointer">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-500 hover:bg-purple-50 transition">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-gray-600 font-medium mb-1">Cliquez pour ajouter des images</p>
                                <p class="text-xs text-gray-500">JPG, PNG ou WEBP (max 2MB par image)</p>
                                <input 
                                    type="file" 
                                    wire:model="newImages" 
                                    accept="image/*" 
                                    multiple
                                    class="hidden"
                                >
                            </div>
                        </label>

                        <div wire:loading wire:target="newImages" class="mt-3 text-sm text-purple-600">
                            Téléchargement en cours...
                        </div>

                        @error('newImages')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('newImages.*')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Statut de publication -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Publication</h2>
                    
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            wire:model="is_published"
                            class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                        >
                        <span class="ml-3 text-sm font-medium text-gray-700">Publier le produit</span>
                    </label>

                    <p class="mt-3 text-xs text-gray-500">
                        Si coché, votre produit sera visible publiquement sur la marketplace.
                    </p>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Actions</h2>

                    <div class="space-y-3">
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 rounded-lg transition shadow-lg disabled:opacity-50"
                            wire:loading.attr="disabled"
                            wire:target="saveProduct, newImages"
                        >
                            <span wire:loading.remove wire:target="saveProduct">{{ $isEditMode ? 'Enregistrer' : 'Créer le produit' }}</span>
                            <span wire:loading wire:target="saveProduct">Enregistrement...</span>
                        </button>

                        <a 
                            href="{{ route('artisan.products.index') }}" 
                            class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 rounded-lg transition"
                        >
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
