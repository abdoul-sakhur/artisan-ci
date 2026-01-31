@extends('layouts.app')

@section('title', 'Commande Confirmée - Artisans du Maroc')

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
                            <br>📞 {{ $order->delivery_address['phone'] }}
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
                                Quantité: {{ $item->quantity }} × {{ number_format($item->price / 100, 2, ',', ' ') }} €
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">
                                {{ number_format($item->total / 100, 2, ',', ' ') }} €
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span>Total payé</span>
                        <span class="text-amber-600">{{ number_format($order->total_amount / 100, 2, ',', ' ') }} €</span>
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
                   class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors font-semibold">
                    📦 Suivre ma commande
                </a>
                <a href="{{ route('front.shop.index') }}" 
                   class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:border-amber-600 hover:text-amber-600 transition-colors font-medium">
                    🛍️ Continuer mes achats
                </a>
            </div>
        </div>

        {{-- Informations pratiques --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="bg-white rounded-lg p-4">
                <div class="text-2xl mb-2">🚚</div>
                <h4 class="font-semibold text-gray-900 mb-1">Livraison</h4>
                <p class="text-sm text-gray-600">Livraison gratuite sous 3-5 jours ouvrés</p>
            </div>
            
            <div class="bg-white rounded-lg p-4">
                <div class="text-2xl mb-2">📞</div>
                <h4 class="font-semibold text-gray-900 mb-1">Support</h4>
                <p class="text-sm text-gray-600">Notre équipe est là pour vous aider 24/7</p>
            </div>
            
            <div class="bg-white rounded-lg p-4">
                <div class="text-2xl mb-2">🔄</div>
                <h4 class="font-semibold text-gray-900 mb-1">Retours</h4>
                <p class="text-sm text-gray-600">Retours gratuits sous 14 jours</p>
            </div>
        </div>
    </div>
</div>
@endsection