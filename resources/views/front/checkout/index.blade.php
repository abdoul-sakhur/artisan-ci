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

        <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><defs><mask id="SVGBcZ8Eejn"><g fill="none"><path fill="#fff" d="M14 4h-4C6.229 4 4.343 4 3.172 5.172c-.844.843-1.08 2.057-1.146 4.078h19.948c-.066-2.021-.302-3.235-1.146-4.078C19.657 4 17.771 4 14 4m-4 16h4c3.771 0 5.657 0 6.828-1.172S22 15.771 22 12q0-.662-.002-1.25H2.002Q1.999 11.338 2 12c0 3.771 0 5.657 1.172 6.828S6.229 20 10 20"/><path fill="#000" fill-rule="evenodd" d="M5.25 16a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75m6.5 0a.75.75 0 0 1 .75-.75H14a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75" clip-rule="evenodd"/></g></mask></defs><path fill="#D97706" d="M0 0h24v24H0z" mask="url(#SVGBcZ8Eejn)"/></svg> Finaliser ma Commande</h1>

        <form @submit.prevent="submitOrder" class="lg:grid lg:grid-cols-3 lg:gap-8">
            
            {{-- Formulaire de commande --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Adresse de livraison --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 24 24"><path fill="#D97706" fill-rule="evenodd" d="M5.25 7.7c0-3.598 3.059-6.45 6.75-6.45c3.608 0 6.612 2.725 6.745 6.208l.478.16c.463.153.87.289 1.191.439c.348.162.667.37.911.709s.341.707.385 1.088c.04.353.04.78.04 1.269v5.748c0 .61 0 1.13-.047 1.547c-.05.438-.161.87-.463 1.237a2.3 2.3 0 0 1-.62.525c-.412.237-.855.276-1.296.253c-.42-.022-.933-.107-1.534-.208l-.041-.007c-1.293-.215-1.814-.296-2.322-.254q-.278.023-.552.083c-.498.109-.976.342-2.159.933l-.122.061c-1.383.692-2.234 1.118-3.154 1.251q-.415.06-.835.06c-.928-.002-1.825-.301-3.28-.786l-.127-.043l-.384-.128l-.037-.012c-.463-.154-.87-.29-1.191-.44c-.348-.162-.667-.37-.911-.709s-.341-.707-.385-1.088c-.04-.353-.04-.78-.04-1.269v-5.02c0-.786 0-1.448.067-1.967c.07-.542.23-1.072.666-1.47a2.3 2.3 0 0 1 .42-.304c.517-.287 1.07-.27 1.605-.166q.164.032.342.078q-.1-.67-.1-1.328m.499 3.01a9 9 0 0 0-1.028-.288c-.395-.077-.525-.03-.586.004a1 1 0 0 0-.14.101c-.053.048-.138.156-.19.556c-.053.41-.055.974-.055 1.825v4.93c0 .539.001.88.03 1.138c.028.238.072.327.112.381c.039.055.109.125.326.226c.236.11.56.219 1.07.39l.384.127c1.624.541 2.279.75 2.936.752q.31 0 .617-.044c.65-.094 1.276-.397 2.82-1.17l.093-.046c1.06-.53 1.714-.857 2.417-1.01q.37-.081.747-.113c.717-.06 1.432.06 2.593.253l.1.017c.655.109 1.083.18 1.407.196c.312.016.419-.025.471-.055a.8.8 0 0 0 .207-.175c.039-.047.097-.146.132-.456c.037-.323.038-.757.038-1.42v-5.667c0-.539-.001-.88-.03-1.138c-.028-.238-.072-.327-.112-.381c-.039-.055-.109-.125-.326-.226c-.236-.11-.56-.219-1.07-.39l-.06-.019a10.7 10.7 0 0 1-1.335 3.788c-.912 1.568-2.247 2.934-3.92 3.663a3.5 3.5 0 0 1-2.794 0c-1.673-.73-3.008-2.095-3.92-3.663a11 11 0 0 1-.934-2.087M12 2.75c-2.936 0-5.25 2.252-5.25 4.95c0 1.418.437 2.98 1.23 4.341c.791 1.362 1.908 2.47 3.223 3.044c.505.22 1.089.22 1.594 0c1.316-.574 2.432-1.682 3.224-3.044c.792-1.36 1.229-2.923 1.229-4.34c0-2.699-2.314-4.951-5.25-4.951m0 4a1.25 1.25 0 1 0 0 2.5a1.25 1.25 0 0 0 0-2.5M9.25 8a2.75 2.75 0 1 1 5.5 0a2.75 2.75 0 0 1-5.5 0" clip-rule="evenodd"/></svg> Adresse de Livraison</h2>
                    
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
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><g fill="none" stroke="#D97706" stroke-width="1.5"><path d="M3 8c0-2.828 0-4.243.879-5.121C4.757 2 6.172 2 9 2h6c2.828 0 4.243 0 5.121.879C21 3.757 21 5.172 21 8v8c0 2.828 0 4.243-.879 5.121C19.243 22 17.828 22 15 22H9c-2.828 0-4.243 0-5.121-.879C3 20.243 3 18.828 3 16z"/><path stroke-linecap="round" d="M8 2.5V22M2 12h2m-2 4h2M2 8h2" opacity="0.5"/><path stroke-linecap="round" d="M11.5 6.5h5m-5 3.5h5"/></g></svg> Notes (optionnel)</h2>
                    <textarea x-model="form.notes" 
                              rows="3" 
                              placeholder="Instructions particulières pour la livraison..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500"></textarea>
                </div>
            </div>

            {{-- Résumé de commande --}}
            <div>
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#D97706" fill-rule="evenodd" d="M11.943 1.25h.114c2.309 0 4.118 0 5.53.19c1.444.194 2.584.6 3.479 1.494c.895.895 1.3 2.035 1.494 3.48c.19 1.411.19 3.22.19 5.529v.114c0 2.309 0 4.118-.19 5.53c-.194 1.444-.6 2.584-1.494 3.479c-.895.895-2.035 1.3-3.48 1.494c-1.411.19-3.22.19-5.529.19h-.114c-2.309 0-4.118 0-5.53-.19c-1.444-.194-2.584-.6-3.479-1.494c-.895-.895-1.3-2.035-1.494-3.48c-.19-1.411-.19-3.22-.19-5.529v-.114c0-2.309 0-4.118.19-5.53c.194-1.444.6-2.584 1.494-3.479c.895-.895 2.035-1.3 3.48-1.494c1.411-.19 3.22-.19 5.529-.19m-5.33 1.676c-1.278.172-2.049.5-2.618 1.069c-.57.57-.897 1.34-1.069 2.619c-.174 1.3-.176 3.008-.176 5.386s.002 4.086.176 5.386c.172 1.279.5 2.05 1.069 2.62c.57.569 1.34.896 2.619 1.068c1.3.174 3.008.176 5.386.176s4.086-.002 5.386-.176c1.279-.172 2.05-.5 2.62-1.069c.569-.57.896-1.34 1.068-2.619c.174-1.3.176-3.008.176-5.386s-.002-4.086-.176-5.386c-.172-1.279-.5-2.05-1.069-2.62c-.57-.569-1.34-.896-2.619-1.068c-1.3-.174-3.008-.176-5.386-.176s-4.086.002-5.386.176m3.904 3.53a.75.75 0 0 1 .026 1.061l-2.857 3a.75.75 0 0 1-1.086 0l-1.143-1.2a.75.75 0 1 1 1.086-1.034l.6.63l2.314-2.43a.75.75 0 0 1 1.06-.026M12.25 9a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75m-1.733 4.457c.3.286.312.76.026 1.06l-2.857 3a.75.75 0 0 1-1.086 0l-1.143-1.2a.75.75 0 1 1 1.086-1.034l.6.63l2.314-2.43a.75.75 0 0 1 1.06-.026M12.25 16a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75" clip-rule="evenodd"/></svg> Récapitulatif</h3>
                    
                    {{-- Articles --}}
                    <div class="space-y-3 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex items-center gap-3">
                            @if(!empty($item['product']->image))
                                <img src="{{ $item['product']->image }}" 
                                     alt="{{ $item['product']->name }}"
                                     class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded"></div>
                            @endif
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
                            <span class="font-medium">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Livraison</span>
                            <span class="font-medium text-green-600">Gratuite</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t">
                            <span class="text-gray-900">Total</span>
                            <span class="text-amber-600">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    {{-- Bouton de validation --}}
                    <button type="submit" 
                            :disabled="loading"
                            class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg hover:bg-amber-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-semibold"
                            :class="{ 'opacity-50': loading }">
                        <span x-show="!loading">Confirmer ma Commande</span>
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