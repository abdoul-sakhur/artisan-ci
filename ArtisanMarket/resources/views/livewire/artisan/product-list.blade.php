<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mes Produits</h1>
            <p class="text-gray-600 mt-1">Gérez votre catalogue de produits</p>
        </div>
        <a href="{{ route('artisan.products.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajouter un produit
        </a>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Recherche -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Nom ou description du produit..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Filtre statut -->
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par statut</label>
                <select 
                    id="filterStatus"
                    wire:model.live="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                    <option value="all">Tous les produits</option>
                    <option value="published">Publiés</option>
                    <option value="unpublished">Non publiés</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des produits -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
                    <!-- Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($product->primaryImage)
                            <img src="{{ Storage::url($product->primaryImage->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Badge statut -->
                        <div class="absolute top-3 right-3">
                            @if($product->is_published)
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow">Publié</span>
                            @else
                                <span class="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full shadow">Brouillon</span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition">{{ $product->name }}</h3>
                        </div>

                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>

                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($product->price, 2) }} DH</p>
                                <p class="text-xs text-gray-500">Stock: {{ $product->quantity_available }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ $product->views_count }} vues</p>
                                @if($product->category)
                                    <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                            <!-- Publier/Dépublier -->
                            <button 
                                wire:click="togglePublish({{ $product->id }})"
                                class="flex-1 px-4 py-2 {{ $product->is_published ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-sm font-medium rounded-lg transition"
                            >
                                {{ $product->is_published ? 'Dépublier' : 'Publier' }}
                            </button>

                            <!-- Modifier -->
                            <a 
                                href="{{ route('artisan.products.edit', $product->id) }}"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition"
                                title="Modifier"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            <!-- Supprimer -->
                            <button 
                                wire:click="deleteProduct({{ $product->id }})"
                                wire:confirm="Êtes-vous sûr de vouloir supprimer ce produit ?"
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition"
                                title="Supprimer"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <!-- État vide -->
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun produit trouvé</h3>
            <p class="text-gray-600 mb-6">
                @if($search || $filterStatus !== 'all')
                    Aucun produit ne correspond à vos critères de recherche.
                @else
                    Commencez par ajouter votre premier produit !
                @endif
            </p>
            @if(!$search && $filterStatus === 'all')
                <a href="{{ route('artisan.products.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajouter votre premier produit
                </a>
            @endif
        </div>
    @endif
</div>
