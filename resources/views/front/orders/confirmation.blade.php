@extends('layouts.front')

@section('title', 'Commande Confirmée - Artisans de Côte d\'Ivoire')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Confirmation --}}
        <div class="text-center mb-12">
            <div class="text-6xl mb-6">✅</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Commande Confirmée !</h1>
            <p class="text-xl text-gray-600 mb-2">
                Merci pour votre commande <strong>{{ $order->order_number }}</strong>
            </p>
            <p class="text-gray-500">
                Un email de confirmation a été envoyé à {{ auth()->user()->email }}
            </p>
        </div>

        {{-- Détails de la commande --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 bg-amber-50 border-b border-amber-100">
                <h2 class="text-xl font-semibold text-gray-900">📋 Détails de votre Commande</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Informations de commande</h3>
                        <div class="space-y-1 text-sm">
                            <div><strong>Numéro:</strong> {{ $order->order_number }}</div>
                            <div><strong>Date:</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            <div><strong>Statut:</strong> 
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Adresse de livraison</h3>
                        <div class="text-sm text-gray-600">
                            {{ $order->delivery_address['first_name'] }} {{ $order->delivery_address['last_name'] }}<br>
                            {{ $order->delivery_address['address'] }}<br>
                            {{ $order->delivery_address['postal_code'] }} {{ $order->delivery_address['city'] }}<br>
                            {{ $order->delivery_address['country'] }}
                            @if($order->delivery_address['phone'])
                            <br>
                            <span class="inline-flex items-center gap-1.5 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $order->delivery_address['phone'] }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Articles commandés --}}
                <h3 class="font-semibold text-gray-900 mb-4">Articles commandés</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <img src="{{ $item->product->images->first()?->image_url ?? '/images/default-product.jpg' }}" 
                             alt="{{ $item->product->name }}"
                             class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-500">Par {{ $item->product->artisan->name }}</p>
                            <div class="text-sm text-gray-600 mt-1">
                                Quantité: {{ $item->quantity }} × {{ number_format($item->price, 0) }} FCFA
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">
                                {{ number_format($item->total, 0) }} FCFA
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span>Total payé</span>
                        <span class="text-amber-600">{{ number_format($order->total_amount, 0) }} FCFA</span>
                    </div>
                </div>
                
                @if($order->notes)
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-900 mb-2">Notes de commande</h4>
                    <p class="text-gray-600 bg-gray-50 p-3 rounded">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="bg-white rounded-xl shadow-sm p-6 text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Et maintenant ?</h3>
            <p class="text-gray-600 mb-6">
                Votre commande est en cours de préparation. Vous recevrez un email dès que vos articles seront expédiés.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('front.client.orders') }}" 
                   class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Suivre ma commande
                </a>
                <a href="{{ route('front.shop.index') }}" 
                   class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors font-medium inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Continuer mes achats
                </a>
            </div>
        </div>

        {{-- Informations pratiques --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="bg-white rounded-lg p-4">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Livraison</h4>
                <p class="text-sm text-gray-600">Livraison gratuite sous 3-5 jours ouvrés</p>
            </div>
            
            <div class="bg-white rounded-lg p-4">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Support</h4>
                <p class="text-sm text-gray-600">Notre équipe est là pour vous aider 24/7</p>
            </div>
            
            <div class="bg-white rounded-lg p-4">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Retours</h4>
                <p class="text-sm text-gray-600">Retours gratuits sous 14 jours</p>
            </div>
        </div>
    </div>
</div>
@endsection