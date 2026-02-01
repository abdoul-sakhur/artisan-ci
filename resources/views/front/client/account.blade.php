@extends('layouts.front')

@section('title', 'Mon Compte - Artisans de Côte d\'Ivoire')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- En-tête --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">📱 Mon Compte</h1>
            <p class="text-gray-600">Bienvenue {{ $user->name }}, gérez votre profil et suivez vos commandes</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Statistiques --}}
            <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-3xl font-bold text-amber-600 mb-2">{{ $ordersCount }}</div>
                    <div class="text-gray-600">Commandes passées</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-3xl font-bold text-amber-600 mb-2">{{ number_format($totalSpent / 100, 0) }} FCFA</div>
                    <div class="text-gray-600">Total dépensé</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-3xl font-bold text-amber-600 mb-2">
                        @if($lastOrder)
                        {{ $lastOrder->created_at->diffForHumans() }}
                        @else
                        Jamais
                        @endif
                    </div>
                    <div class="text-gray-600">Dernière commande</div>
                </div>
            </div>
            
            {{-- Profil --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">👤 Informations Personnelles</h2>
                    
                    @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('front.client.profile.update') }}" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                            Mettre à jour le profil
                        </button>
                    </form>
                </div>
                
                {{-- Changer le mot de passe --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">🔒 Changer le Mot de Passe</h2>
                    
                    <form method="POST" action="{{ route('front.client.password.update') }}" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                            <input type="password" 
                                   name="current_password" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" 
                                   name="password" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        
                        <button type="submit" 
                                class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                            Changer le mot de passe
                        </button>
                    </form>
                </div>
            </div>
            
            {{-- Actions rapides --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🚀 Actions Rapides</h3>
                    <div class="space-y-3">
                        <a href="{{ route('front.client.orders') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                            📦 Mes Commandes
                        </a>
                        <a href="{{ route('front.shop.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors font-medium">
                            🛍️ Continuer mes achats
                        </a>
                        <a href="{{ route('front.cart.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors font-medium">
                            🛍️ Mon Panier
                        </a>
                    </div>
                </div>
                
                {{-- Support --}}
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">🎆 Besoin d'Aide ?</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Notre équipe support est là pour vous aider avec vos commandes et questions.
                    </p>
                    <div class="space-y-2">
                        <a href="mailto:support@artisansdumaroc.com" 
                           class="block text-amber-600 hover:text-amber-700 text-sm font-medium">
                            📧 support@artisansdumaroc.com
                        </a>
                        <div class="text-gray-600 text-sm">
                            📞 +212 5 22 XX XX XX
                        </div>
                    </div>
                </div>
                
                @if($lastOrder)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📦 Dernière Commande</h3>
                    <div class="text-sm space-y-1">
                        <div><strong>N° :</strong> {{ $lastOrder->order_number }}</div>
                        <div><strong>Date :</strong> {{ $lastOrder->created_at->format('d/m/Y') }}</div>
                        <div><strong>Statut :</strong> 
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $lastOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($lastOrder->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                   ($lastOrder->status === 'shipped' ? 'bg-purple-100 text-purple-800' : 
                                   ($lastOrder->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ ucfirst($lastOrder->status) }}
                            </span>
                        </div>
                        <div><strong>Total :</strong> {{ number_format($lastOrder->total_amount / 100, 2, ',', ' ') }} FCFA</div>
                    </div>
                    <a href="{{ route('front.orders.show', $lastOrder->order_number) }}" 
                       class="mt-3 inline-block text-amber-600 hover:text-amber-700 text-sm font-medium">
                        Voir les détails →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection