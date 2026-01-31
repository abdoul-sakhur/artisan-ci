<div>
    <!-- Header Section -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Modération des Produits</h3>
        <p class="mt-1 text-sm text-gray-600">Gérez et modérez les produits artisanaux</p>
    </div>

    <!-- Filters -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                    Rechercher
                </label>
                <input 
                    type="text" 
                    id="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Nom du produit, artisan..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <label for="categoryFilter" class="block text-sm font-medium text-gray-700 mb-2">
                    Catégorie
                </label>
                <select 
                    id="categoryFilter"
                    wire:model.live="categoryFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Toutes</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">
                    Statut
                </label>
                <select 
                    id="statusFilter"
                    wire:model.live="statusFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="all">Tous</option>
                    <option value="published">Publiés</option>
                    <option value="unpublished">Non publiés</option>
                    <option value="featured">En vedette</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Product Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($product->primaryImage)
                            <img 
                                src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-2 left-2 flex flex-col gap-2">
                            @if($product->is_featured)
                                <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded">
                                    ⭐ Vedette
                                </span>
                            @endif
                            @if(!$product->is_published)
                                <span class="px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded">
                                    Masqué
                                </span>
                            @endif
                        </div>

                        <!-- Views Count -->
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                            👁️ {{ $product->views_count }} vues
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-gray-900 truncate">
                                    {{ $product->name }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    Par {{ $product->artisan->shop_name }}
                                </p>
                            </div>
                            <div class="text-lg font-bold text-indigo-600">
                                {{ number_format($product->price, 2) }} €
                            </div>
                        </div>

                        <!-- Category & Stock -->
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $product->category->name }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Stock: {{ $product->quantity }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-2">
                            @if($product->is_published)
                                <button 
                                    wire:click="unpublish({{ $product->id }})"
                                    class="flex-1 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded transition-colors duration-200">
                                    Masquer
                                </button>
                            @else
                                <button 
                                    wire:click="publish({{ $product->id }})"
                                    class="flex-1 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded transition-colors duration-200">
                                    Publier
                                </button>
                            @endif

                            <button 
                                wire:click="toggleFeatured({{ $product->id }})"
                                class="flex-1 px-3 py-1.5 {{ $product->is_featured ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white text-sm font-medium rounded transition-colors duration-200">
                                {{ $product->is_featured ? '⭐ Retiré' : '⭐ Vedette' }}
                            </button>

                            <button 
                                wire:click="delete({{ $product->id }})"
                                wire:confirm="Êtes-vous sûr de vouloir supprimer ce produit ?"
                                class="px-3 py-1.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun produit</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if($search)
                    Aucun résultat pour "{{ $search }}"
                @else
                    Aucun produit disponible pour le moment.
                @endif
            </p>
        </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-4 right-4 z-50">
        <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Chargement...
        </div>
    </div>
</div>
