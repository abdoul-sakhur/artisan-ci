@extends('layouts.front')

@section('title', 'Boutique - Artisans de Côte d\'Ivoire')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="shopFilters()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Titre et breadcrumb --}}
        <div class="mb-8">
            <nav class="text-sm mb-4">
                <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-amber-600">Accueil</a>
                <span class="mx-2 text-gray-400">•</span>
                <span class="text-gray-900 font-medium">Boutique</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 24 24"><path fill="#D97706" d="M16.528 2H7.472c-1.203 0-1.804 0-2.288.299c-.483.298-.752.836-1.29 1.912L2.491 7.76c-.325.82-.608 1.786-.062 2.479A2 2 0 0 0 6 9a2 2 0 1 0 4 0a2 2 0 1 0 4 0a2 2 0 1 0 4 0a2 2 0 0 0 3.571 1.238c.546-.693.262-1.659-.062-2.479l-1.404-3.548c-.538-1.076-.806-1.614-1.29-1.912C18.332 2 17.73 2 16.528 2"/><path fill="#D97706" fill-rule="evenodd" d="M20 21.25h2a.75.75 0 0 1 0 1.5H2a.75.75 0 0 1 0-1.5h2V12.5c.744 0 1.433-.232 2-.627a3.5 3.5 0 0 0 2 .627c.744 0 1.433-.232 2-.627a3.5 3.5 0 0 0 2 .627c.744 0 1.433-.232 2-.627a3.5 3.5 0 0 0 2 .627c.744 0 1.433-.232 2-.627a3.5 3.5 0 0 0 2 .627zm-10.5 0h5V18.5c0-.935 0-1.402-.201-1.75a1.5 1.5 0 0 0-.549-.55c-.348-.2-.815-.2-1.75-.2s-1.402 0-1.75.2a1.5 1.5 0 0 0-.549.55c-.201.348-.201.815-.201 1.75z" clip-rule="evenodd"/></svg>
                Notre Boutique
            </h1>
            <p class="text-gray-600">Découvrez {{ $products->total() }} œuvres d'art authentiques.</p>
        </div>

        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            
            {{-- Sidebar Filtres --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#D97706" fill-rule="evenodd" d="M5 3h14L8.816 13.184a2.7 2.7 0 0 0-.778-1.086c-.228-.198-.547-.377-1.183-.736l-2.913-1.64c-.949-.533-1.423-.8-1.682-1.23C2 8.061 2 7.541 2 6.503v-.69c0-1.326 0-1.99.44-2.402C2.878 3 3.585 3 5 3" clip-rule="evenodd"/><path fill="#D97706" d="M22 6.504v-.69c0-1.326 0-1.99-.44-2.402C21.122 3 20.415 3 19 3L8.815 13.184q.075.193.121.403c.064.285.064.619.064 1.286v2.67c0 .909 0 1.364.252 1.718c.252.355.7.53 1.594.88c1.879.734 2.818 1.101 3.486.683S15 19.452 15 17.542v-2.67c0-.666 0-1 .063-1.285a2.68 2.68 0 0 1 .9-1.49c.227-.197.545-.376 1.182-.735l2.913-1.64c.948-.533 1.423-.8 1.682-1.23c.26-.43.26-.95.26-1.988" opacity="0.5"/></svg> Filtres</h3>
                    
                    <form method="GET" action="{{ route('front.shop.index') }}" class="space-y-6">
                        
                        {{-- Recherche --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nom, description..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>

                        {{-- Catégories --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégories</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="category[]" 
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, (array) request('category', [])) ? 'checked' : '' }}
                                           class="rounded text-amber-600 focus:ring-amber-500">
                                    <span class="ml-2 text-sm">
                                        {{ $category->icon }} {{ $category->name }}
                                        <span class="text-gray-500">({{ $category->products_count }})</span>
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Artisans --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Artisan</label>
                            <select name="artisan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                                <option value="">Tous les artisans</option>
                                @foreach($artisans as $artisan)
                                <option value="{{ $artisan->id }}" {{ request('artisan') == $artisan->id ? 'selected' : '' }}>
                                    {{ $artisan->name }} ({{ $artisan->products_count }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Prix --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix (FCFA)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" 
                                       name="min_price" 
                                       value="{{ request('min_price') }}"
                                       placeholder="Min" 
                                       min="0"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                                <input type="number" 
                                       name="max_price" 
                                       value="{{ request('max_price') }}"
                                       placeholder="Max" 
                                       min="0"
                                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex flex-col gap-2">
                            <button type="submit" 
                                    class="w-full bg-amber-600 text-white py-2 px-4 rounded-lg hover:bg-amber-700 transition-colors font-medium">
                                Appliquer les filtres
                            </button>
                            <a href="{{ route('front.shop.index') }}" 
                               class="w-full text-center text-gray-600 hover:text-amber-600 py-2 px-4 border border-gray-300 rounded-lg hover:border-amber-600 transition-colors">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Zone principale --}}
            <div class="lg:col-span-3 mt-8 lg:mt-0">
                
                {{-- Barre d'options --}}
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        
                        {{-- Résultats --}}
                        <div class="text-sm text-gray-600">
                            Affichage de {{ $products->firstItem() ?? 0 }} à {{ $products->lastItem() ?? 0 }} 
                            sur {{ $products->total() }} résultats
                        </div>

                        {{-- Tri --}}
                        <div class="flex items-center gap-2">
                            <label class="text-sm font-medium text-gray-700">Trier par :</label>
                            <select name="sort" 
                                    onchange="window.location.href = updateUrlParameter(window.location.href, 'sort', this.value)"
                                    class="px-3 py-1 border border-gray-300 rounded focus:ring-amber-500 focus:border-amber-500">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    Plus récents
                                </option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>
                                    Plus populaires
                                </option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                    Prix croissant
                                </option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Prix décroissant
                                </option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                    Alphabétique
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Grille des produits --}}
                @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($products as $product)
                        @include('components.ui.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="bg-white rounded-xl shadow-sm p-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>

                @else
                {{-- État vide --}}
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun produit trouvé</h3>
                    <p class="text-gray-600 mb-6">
                        Essayez de modifier vos filtres ou parcourez toutes nos créations
                    </p>
                    <a href="{{ route('front.shop.index') }}" 
                       class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors">
                        Voir tous les produits
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function shopFilters() {
    return {
        loading: false,
        
        async addToCart(productId) {
            this.loading = true;
            
            try {
                const response = await fetch('{{ route("front.cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    // Mise à jour du compteur de panier si existe
                    const cartBadge = document.querySelector('[x-text="cartCount"]');
                    if (cartBadge) {
                        this.$dispatch('cart-updated', data.cart);
                    }
                    
                    // Notification de succès
                    this.showNotification('Produit ajouté au panier', 'success');
                } else {
                    this.showNotification(data.message || 'Erreur lors de l\'ajout', 'error');
                }
            } catch (error) {
                this.showNotification('Erreur réseau', 'error');
            }
            
            this.loading = false;
        },
        
        showNotification(message, type) {
            // Système de notification simple
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.remove(), 3000);
        }
    }
}

function updateUrlParameter(url, param, paramVal) {
    const newAdditionalURL = param + '=' + paramVal;
    let tempArray = url.split('?');
    let baseURL = tempArray[0];
    let additionalURL = tempArray[1];
    let temp = '';

    if (additionalURL) {
        tempArray = additionalURL.split('&');
        for (let i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] !== param) {
                temp += tempArray[i] + '&';
            }
        }
    }

    return baseURL + '?' + temp + newAdditionalURL;
}
</script>
@endsection