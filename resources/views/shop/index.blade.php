<x-public-layout>
    <x-slot name="title">Boutique - ArtisanMarket</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- En-tête --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Boutique</h1>
            <p class="text-gray-600">{{ $products->total() }} produits disponibles</p>
        </div>

        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            
            {{-- Sidebar Filtres --}}
            <div class="lg:col-span-1 mb-8 lg:mb-0">
                <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-20">
                    <h2 class="font-semibold text-gray-900 mb-4">Filtres</h2>
                    
                    <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
                        
                        {{-- Recherche --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Nom du produit..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                            >
                        </div>

                        {{-- Catégorie --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Artisan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Artisan</label>
                            <select name="artisan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                                <option value="">Tous les artisans</option>
                                @foreach($artisans as $artisan)
                                    <option value="{{ $artisan->id }}" {{ request('artisan') == $artisan->id ? 'selected' : '' }}>
                                        {{ $artisan->shop_name }} ({{ $artisan->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Prix --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix (FCFA)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input 
                                    type="number" 
                                    name="min_price" 
                                    value="{{ request('min_price') }}"
                                    placeholder="Min"
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                >
                                <input 
                                    type="number" 
                                    name="max_price" 
                                    value="{{ request('max_price') }}"
                                    placeholder="Max"
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                >
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="space-y-2">
                            <button type="submit" class="w-full bg-gray-900 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-800 transition">
                                Appliquer les filtres
                            </button>
                            @if(request()->hasAny(['search', 'category', 'artisan', 'min_price', 'max_price']))
                                <a href="{{ route('shop.index') }}" class="block text-center w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                    Réinitialiser
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Contenu principal --}}
            <div class="lg:col-span-3">
                
                {{-- Tri --}}
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $products->total() }} résultats</span>
                        
                        <form method="GET" action="{{ route('shop.index') }}" id="sortForm">
                            @foreach(request()->except('sort') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            
                            <select 
                                name="sort" 
                                onchange="document.getElementById('sortForm').submit()"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent text-sm"
                            >
                                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Plus récents</option>
                                <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nom A-Z</option>
                                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Grille de produits --}}
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <a href="{{ route('shop.show', $product->slug) }}" class="group">
                                <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition border border-gray-200">
                                    {{-- Image --}}
                                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                                        @if($product->images->first())
                                            <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        @if($product->is_featured)
                                            <div class="absolute top-2 right-2">
                                                <span class="bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-semibold">⭐</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Informations --}}
                                    <div class="p-4">
                                        <p class="text-xs text-gray-500 mb-1">{{ $product->category->name }}</p>
                                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-gray-600">
                                            {{ $product->name }}
                                        </h3>
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-lg font-bold text-gray-900">
                                                {{ number_format($product->price, 0) }} FCFA
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                Stock: {{ $product->quantity }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">Par {{ $product->artisan->shop_name }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                        <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun produit trouvé</h3>
                        <p class="text-gray-600 mb-4">Essayez de modifier vos critères de recherche</p>
                        <a href="{{ route('shop.index') }}" class="inline-block text-gray-900 font-medium hover:text-gray-600">
                            Réinitialiser les filtres →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-public-layout>
