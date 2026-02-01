@extends('layouts.front')

@section('title', 'Mon Panier - Artisans ')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="cartPage()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6">
            <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-amber-600">Accueil</a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('front.shop.index') }}" class="text-gray-500 hover:text-amber-600">Boutique</a>
            <span class="mx-2 text-gray-400">•</span>
            <span class="text-gray-900 font-medium">Mon Panier</span>
        </nav>

        <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="#D97706" d="M6.005 9h13.938l.5-2H8.005V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5.004a1 1 0 0 1-1-1V4h-2V2h3a1 1 0 0 1 1 1zm0 14a2 2 0 1 1 0-4a2 2 0 0 1 0 4m12 0a2 2 0 1 1 0-4a2 2 0 0 1 0 4"/></svg>
            Mon Panier
        </h1>

        @if($cartItems && count($cartItems) > 0)
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            
            {{-- Articles du panier --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">
                            Articles ({{ $count }})
                        </h2>

                        <div class="space-y-6">
                            @foreach($cartItems as $index => $item)
                            <div class="flex flex-col sm:flex-row gap-4 pb-6 border-b border-gray-200 last:border-0" 
                                 x-data="{ updating: false }">
                                
                                {{-- Image produit --}}
                                <div class="shrink-0">
                                    <a href="{{ route('front.shop.product', $item['product']->slug) }}">
                                        @if(!empty($item['product']->image))
                                            <img src="{{ $item['product']->image }}" 
                                                 alt="{{ $item['product']->name }}"
                                                 class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg">
                                        @else
                                            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-200 rounded-lg"></div>
                                        @endif
                                    </a>
                                </div>

                                {{-- Détails produit --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-semibold text-gray-900">
                                                <a href="{{ route('front.shop.product', $item['product']->slug) }}" 
                                                   class="hover:text-amber-600 transition-colors">
                                                    {{ $item['product']->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                Ref: {{ $item['product']->slug }}
                                            </p>
                                        </div>
                                        <button @click="removeFromCart({{ $item['product']->id }})"
                                                class="text-red-500 hover:text-red-700 transition-colors"
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Prix unitaire --}}
                                    <div class="text-lg font-semibold text-amber-600 mb-3">
                                        {{ $item['product']->formatted_price }}
                                    </div>

                                    {{-- Contrôles quantité --}}
                                    <div class="flex items-center gap-3">
                                        <label class="text-sm font-medium text-gray-700">Quantité:</label>
                                        <div class="flex items-center">
                                            <button @click="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] }} - 1)"
                                                    :disabled="updating || {{ $item['quantity'] }} <= 1"
                                                    class="p-1 rounded-l border border-gray-300 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                            <span class="px-3 py-1 border-t border-b border-gray-300 bg-gray-50 min-w-[3rem] text-center">
                                                {{ $item['quantity'] }}
                                            </span>
                                            <button @click="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] }} + 1)"
                                                    :disabled="updating || {{ $item['quantity'] }} >= {{ $item['product']->stock_quantity }}"
                                                    class="p-1 rounded-r border border-gray-300 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            (Stock: {{ $item['product']->stock_quantity }})
                                        </div>
                                    </div>

                                    {{-- Sous-total --}}
                                    <div class="mt-3">
                                        <span class="text-sm text-gray-600">Sous-total: </span>
                                        <span class="font-semibold text-gray-900">{{ $item['formatted_subtotal'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('front.shop.index') }}" 
                       class="flex-1 bg-gray-100 text-gray-700 text-center py-3 px-6 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        ← Continuer mes achats
                    </a>
                    <button @click="clearCart()"
                            class="flex-1 bg-red-100 text-red-700 py-3 px-6 rounded-lg hover:bg-red-200 transition-colors font-medium flex items-center justify-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#640202" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>                         Vider le panier
                    </button>
                </div>
            </div>

            {{-- Résumé de commande --}}
            <div class="mt-8 lg:mt-0">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex justify-between"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#D97706" d="M4 3a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm3 6V7h10v2zm0 4v-2h10v2zm10 4H7v-2h10z"/></svg> Résumé</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium">{{ number_format($total, 2, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-medium text-green-600">Gratuite</span>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-amber-600">
                                    {{ number_format($total, 2, ',', ' ') }} FCFA
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @auth
                        <a href="{{ route('front.checkout.index') }}" 
                           class="w-full bg-amber-600 text-white text-center py-3 px-6 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                            💳 Passer la commande
                        </a>
                        @else
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-3">Connectez-vous pour commander</p>
                            <a href="{{ route('login') }}" 
                               class="w-full bg-amber-600 text-white text-center py-3 px-6 rounded-lg hover:bg-amber-700 transition-colors font-semibold block flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#fff" d="M4 15h2v5h12V4H6v5H4V3a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm6-4V8l5 4l-5 4v-3H2v-2z"/></svg> Se connecter
                            </a>
                            <a href="{{ route('register') }}" 
                               class="w-full mt-2 border border-amber-600 text-amber-600 text-center py-2 px-6 rounded-lg hover:bg-amber-50 transition-colors font-medium block">
                                Créer un compte
                            </a>
                        </div>
                        @endauth
                    </div>

                    {{-- Garanties --}}
                    <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Livraison gratuite
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Paiement sécurisé
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Support client 24/7
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- Panier vide --}}
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="mb-6">
                <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Votre panier est vide</h2>
            <p class="text-gray-600 mb-8">
                Découvrez nos magnifiques créations artisanales et ajoutez-les à votre panier
            </p>
            <div class="space-y-4">
                <a href="{{ route('front.shop.index') }}" 
                   class="bg-amber-600 text-white px-8 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Découvrir la boutique
                </a>
                <div class="flex justify-center gap-6 text-sm text-gray-500">
                    <a href="{{ route('front.shop.index', ['sort' => 'latest']) }}" 
                       class="hover:text-amber-600 transition-colors">
                        Nouveautés
                    </a>
                    <a href="{{ route('front.shop.index') }}?category=" 
                       class="hover:text-amber-600 transition-colors">
                        Œuvres en vedette
                    </a>
                    <a href="{{ route('front.artisans.index') }}" 
                       class="hover:text-amber-600 transition-colors">
                        Nos artisans
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function cartPage() {
    return {
        loading: false,
        
        async updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) return;
            
            this.loading = true;
            
            try {
                const response = await fetch('{{ route("front.cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: newQuantity
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    // Recharger la page pour mettre à jour les totaux
                    window.location.reload();
                } else {
                    this.showNotification(data.message, 'error');
                }
            } catch (error) {
                this.showNotification('Erreur lors de la mise à jour', 'error');
            }
            
            this.loading = false;
        },
        
        async removeFromCart(productId) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch('{{ route("front.cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    this.showNotification(data.message, 'error');
                }
            } catch (error) {
                this.showNotification('Erreur lors de la suppression', 'error');
            }
            
            this.loading = false;
        },
        
        async clearCart() {
            if (!confirm('Êtes-vous sûr de vouloir vider complètement votre panier ?')) {
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch('{{ route("front.cart.clear") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    this.showNotification('Erreur lors du vidage du panier', 'error');
                }
            } catch (error) {
                this.showNotification('Erreur réseau', 'error');
            }
            
            this.loading = false;
        },
        
        showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.remove(), 3000);
        }
    }
}
</script>
@endsection