@extends('layouts.front')

@section('title', 'Commande - Artisans du ')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="checkoutForm()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb --}}
        <nav class="text-sm mb-6">
            <a href="{{ route('front.home') }}" class="text-gray-500 hover:text-amber-600">Accueil</a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('front.cart.index') }}" class="text-gray-500 hover:text-amber-600">Panier</a>
            <span class="mx-2 text-gray-400">•</span>
            <span class="text-gray-900 font-medium">Commande</span>
        </nav>

        <h1 class="text-3xl font-bold text-gray-900 mb-8">💳 Finaliser ma Commande</h1>

        <form @submit.prevent="submitOrder" class="lg:grid lg:grid-cols-3 lg:gap-8">
            
            {{-- Formulaire de commande --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Adresse de livraison --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">📍 Adresse de Livraison</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                            <input type="text" 
                                   x-model="form.delivery_address.first_name"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                            <input type="text" 
                                   x-model="form.delivery_address.last_name"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse complète *</label>
                        <input type="text" 
                               x-model="form.delivery_address.address"
                               placeholder="Numéro, rue, bâtiment..."
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                            <input type="text" 
                                   x-model="form.delivery_address.city"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Code postal *</label>
                            <input type="text" 
                                   x-model="form.delivery_address.postal_code"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="tel" 
                                   x-model="form.delivery_address.phone"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>
                </div>

                {{-- Notes de commande --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">📝 Notes (optionnel)</h2>
                    <textarea x-model="form.notes" 
                              rows="3" 
                              placeholder="Instructions particulières pour la livraison..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500"></textarea>
                </div>
            </div>

            {{-- Résumé de commande --}}
            <div>
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">📋 Récapitulatif</h3>
                    
                    {{-- Articles --}}
                    <div class="space-y-3 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3">
                            <img src="{{ $item['product']->image ?? '/images/default-product.jpg' }}" 
                                 alt="{{ $item['product']->name }}"
                                 class="w-12 h-12 object-cover rounded">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                    {{ $item['product']->name }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ $item['quantity'] }} × {{ $item['product']->formatted_price }}
                                </p>
                            </div>
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $item['formatted_subtotal'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totaux --}}
                    <div class="space-y-2 mb-6 pt-4 border-t">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium">{{ number_format($total / 100, 2, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-medium text-green-600">Gratuite</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t">
                            <span class="text-gray-900">Total</span>
                            <span class="text-amber-600">{{ number_format($total / 100, 2, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    {{-- Bouton de validation --}}
                    <button type="submit" 
                            :disabled="loading"
                            class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg hover:bg-amber-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-semibold"
                            :class="{ 'opacity-50': loading }">
                        <span x-show="!loading">✅ Confirmer ma Commande</span>
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Traitement...
                        </span>
                    </button>

                    {{-- Informations sécurité --}}
                    <div class="mt-6 pt-4 border-t text-sm text-gray-500">
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Paiement sécurisé
                        </div>
                        <p class="text-xs leading-relaxed">
                            Vos données personnelles sont protégées et ne seront utilisées que pour le traitement de votre commande.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function checkoutForm() {
    return {
        loading: false,
        form: {
            delivery_address: {
                first_name: '{{ auth()->user()->name ?? "" }}',
                last_name: '',
                address: '',
                city: '',
                postal_code: '',
                country: 'France',
                phone: '{{ auth()->user()->phone ?? "" }}'
            },
            notes: ''
        },
        
        async submitOrder() {
            this.loading = true;
            
            try {
                const response = await fetch('{{ route("front.checkout.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });

                const data = await response.json();
                
                if (response.ok) {
                    // Redirection vers la page de confirmation
                    window.location.href = data.redirect || '{{ route("front.home") }}';
                } else {
                    // Gestion des erreurs de validation
                    if (data.errors) {
                        let errorMessages = [];
                        Object.values(data.errors).forEach(errors => {
                            errorMessages = errorMessages.concat(errors);
                        });
                        this.showNotification(errorMessages.join('\n'), 'error');
                    } else {
                        this.showNotification(data.message || 'Erreur lors de la création de la commande', 'error');
                    }
                }
            } catch (error) {
                console.error('Erreur:', error);
                this.showNotification('Erreur réseau. Veuillez réessayer.', 'error');
            }
            
            this.loading = false;
        },
        
        showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.innerHTML = `<div class="whitespace-pre-line">${message}</div>`;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.remove(), 5000);
        }
    }
}
</script>
@endsection