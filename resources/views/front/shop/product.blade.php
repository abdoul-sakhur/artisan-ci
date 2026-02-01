@extends('layouts.front')

@section('title', $product->name . ' - Artisans ')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="productDetail()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6">
            <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-amber-600">Accueil</a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('front.shop.index') }}" class="text-gray-500 hover:text-amber-600">Boutique</a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('front.shop.index', ['category' => $product->category_id]) }}" 
               class="text-gray-500 hover:text-amber-600">{{ $product->category->name }}</a>
            <span class="mx-2 text-gray-400">•</span>
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </nav>

        {{-- Produit Principal --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
            
            {{-- Galerie d'images --}}
            <div class="space-y-4">
                <div class="relative bg-white rounded-xl shadow-sm overflow-hidden">
                    <img x-ref="mainImage" 
                         src="{{ $product->images->first()?->image_url ?? '/images/default-product.jpg' }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-96 lg:h-[500px] object-cover">
                    
                    {{-- Badges --}}
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($product->is_featured)
                        <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-sm font-semibold inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Vedette
                        </span>
                        @endif
                        @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Stock limité ({{ $product->stock_quantity }})
                        </span>
                        @elseif($product->stock_quantity == 0)
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Rupture de stock
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Miniatures --}}
                @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                    <button @click="changeMainImage('{{ $image->image_url }}')"
                            class="relative bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <img src="{{ $image->image_url }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-20 object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Informations produit --}}
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                {{-- Prix et stock --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="text-3xl font-bold text-amber-600">
                        {{ $product->formatted_price }}
                    </div>
                    <div class="text-right">
                        @if($product->stock_quantity > 0)
                        <div class="text-green-600 font-semibold">✅ En stock</div>
                        <div class="text-sm text-gray-500">{{ $product->stock_quantity }} disponibles</div>
                        @else
                        <div class="text-red-600 font-semibold">❌ Rupture</div>
                        @endif
                    </div>
                </div>

                {{-- Référence --}}
                <div class="text-sm text-gray-500 mb-6">
                    <strong>Référence:</strong> {{ $product->sku }}
                </div>

                {{-- Description --}}
                <div class="prose prose-sm mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                    <div class="text-gray-600 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                {{-- Ajouter au panier --}}
                <form @submit.prevent="addToCart" class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                            <select x-model="quantity" 
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500"
                                    :disabled="loading || {{ $product->stock_quantity }} === 0">
                                @for($i = 1; $i <= min(10, $product->stock_quantity); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="flex-1">
                            <button type="submit" 
                                    :disabled="loading || {{ $product->stock_quantity }} === 0"
                                    class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg hover:bg-amber-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors font-semibold"
                                    :class="{ 'opacity-50': loading }">
                                <span x-show="!loading" class="inline-flex items-center justify-center gap-2">
                                    @if($product->stock_quantity > 0)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Ajouter au panier
                                    @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Produit indisponible
                                    @endif
                                </span>
                                <span x-show="loading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Ajout en cours...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Actions supplémentaires --}}
                <div class="flex gap-3 mt-4">
                    <button class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors">
                        ❤️ Favoris
                    </button>
                    <button class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors">
                        📤 Partager
                    </button>
                </div>

                {{-- Statistiques --}}
                <div class="flex items-center gap-6 mt-6 pt-6 border-t border-gray-200 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $product->views_count }} vues
                    </div>
                    <div>Ajouté le {{ $product->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Card Artisan --}}
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-8 mb-12">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="shrink-0">
                    <img src="{{ $product->artisan->logo_url ?? '/images/default-artisan.jpg' }}" 
                         alt="{{ $product->artisan->name }}"
                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 flex items-center justify-center md:justify-start gap-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $product->artisan->name }}
                    </h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($product->artisan->bio, 200) }}</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('front.artisans.show', $product->artisan->shop_slug) }}" 
                           class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                            Découvrir l'atelier
                        </a>
                        <div class="text-sm text-gray-600 flex items-center justify-center sm:justify-start gap-4">
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                {{ $product->artisan->products()->where('is_published', true)->count() }} créations
                            </span>
                            @if($product->artisan->phone)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Contact disponible
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produits similaires --}}
        @if($relatedProducts->count() > 0)
        <section class="mb-12">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Œuvres similaires</h2>
                <a href="{{ route('front.shop.index', ['category' => $product->category_id]) }}" 
                   class="text-amber-600 hover:text-amber-700 font-semibold">
                    Voir toute la catégorie →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="relative">
                        <a href="{{ route('front.shop.product', $relatedProduct->slug) }}">
                            <img src="{{ $relatedProduct->images->first()?->image_url ?? '/images/default-product.jpg' }}" 
                                 alt="{{ $relatedProduct->name }}"
                                 class="w-full h-48 object-cover">
                        </a>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $relatedProduct->artisan->name }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-amber-600">{{ $relatedProduct->formatted_price }}</span>
                            <a href="{{ route('front.shop.product', $relatedProduct->slug) }}" 
                               class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                Voir →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Autres œuvres de l'artisan --}}
        @if($artisanProducts->count() > 0)
        <section>
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Autres créations de {{ $product->artisan->name }}</h2>
                <a href="{{ route('front.artisans.show', $product->artisan->shop_slug) }}" 
                   class="text-amber-600 hover:text-amber-700 font-semibold">
                    Voir toutes ses œuvres →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($artisanProducts as $artisanProduct)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow overflow-hidden">
                    <div class="relative">
                        <a href="{{ route('front.shop.product', $artisanProduct->slug) }}">
                            <img src="{{ $artisanProduct->images->first()?->image_url ?? '/images/default-product.jpg' }}" 
                                 alt="{{ $artisanProduct->name }}"
                                 class="w-full h-48 object-cover">
                        </a>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $artisanProduct->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $artisanProduct->category->name }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-amber-600">{{ $artisanProduct->formatted_price }}</span>
                            <a href="{{ route('front.shop.product', $artisanProduct->slug) }}" 
                               class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                                Voir →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>

<script>
function productDetail() {
    return {
        quantity: 1,
        loading: false,
        
        changeMainImage(imageUrl) {
            this.$refs.mainImage.src = imageUrl;
        },
        
        async addToCart() {
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
                        product_id: {{ $product->id }},
                        quantity: this.quantity
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    // Mise à jour du compteur de panier
                    this.$dispatch('cart-updated', data.cart);
                    
                    // Notification de succès
                    this.showNotification('Produit ajouté au panier avec succès ! 🛒', 'success');
                    
                    // Réinitialiser la quantité
                    this.quantity = 1;
                } else {
                    this.showNotification(data.message || 'Erreur lors de l\'ajout au panier', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                this.showNotification('Erreur réseau. Veuillez réessayer.', 'error');
            }
            
            this.loading = false;
        },
        
        showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 shadow-lg transform transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <span class="mr-2">${type === 'success' ? '✅' : '❌'}</span>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animation d'entrée
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            // Suppression après 4 secondes
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }
    }
}
</script>
@endsection